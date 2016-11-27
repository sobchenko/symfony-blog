<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class AbstractJsonController extends FOSRestController
{
    const HTTP_STATUS_CODE_OK = 200;
    const HTTP_STATUS_CODE_INTERNAL_ERROR = 500;

    protected function returnSuccessResponse($data, $statusCode = self::HTTP_STATUS_CODE_OK)
    {

    }

    protected function returnFailedResponse(\Exception $e, $statusCode = self::HTTP_STATUS_CODE_INTERNAL_ERROR)
    {
        return new JsonResponse(
            $this->getSerializer()->serialize([
                'message' => $e->getMessage(),
                'code' => $statusCode
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