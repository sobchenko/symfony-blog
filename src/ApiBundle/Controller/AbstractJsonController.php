<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AbstractJsonController extends FOSRestController
{
    const HTTP_STATUS_CODE_OK = 200;
    const HTTP_STATUS_CODE_CREATED = 201;
    const HTTP_STATUS_CODE_NO_CONTENT = 204;
    const HTTP_STATUS_CODE_BAD_REQUEST = 400;
    const HTTP_STATUS_CODE_NOT_FOUND = 404;
    const HTTP_STATUS_CODE_UNPROCESSABLE_ENTITY = 422;
    const HTTP_STATUS_CODE_GONE = 410;
    const HTTP_STATUS_CODE_INTERNAL_ERROR = 500;

    protected function createSuccessfulResponse($data, $statusCode = self::HTTP_STATUS_CODE_OK)
    {
        $context = SerializationContext::create()
            ->enableMaxDepthChecks()
            ->setSerializeNull(true)
        ;
        $data = $this->getSerializer()->serialize($data, 'json', $context);

        return new Response(
            $data,
            $statusCode,
            ['Content-Type' => 'application/json']
        );
    }

    protected function createFailedResponse(\Exception $e, $statusCode = self::HTTP_STATUS_CODE_INTERNAL_ERROR)
    {
        return new JsonResponse(
            $this->getSerializer()->serialize([
                'message' => $e->getMessage(),
                'code' => $statusCode,
                ], 'json'),
            $statusCode
        );
    }

    /**
     * @return Serializer
     */
    protected function getSerializer()
    {
        return $this->get('jms_serializer');
    }
}
