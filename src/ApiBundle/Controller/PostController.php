<?php

namespace ApiBundle\Controller;

use ApiBundle\Controller\AbstractJsonController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractJsonController
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Create new blog post",
     *     parameters={
     *         {"name"="title", "dataType"="string", "required"=true, "description"="post title"},
     *     },
     *     statusCodes={
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Post("post/create", name="post_create")
     */
    public function createPostAction(Request $request)
    {
        return $this->returnSuccessResponse('OK');
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Remove blog post with id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "required"=true,
     *              "description"="post id to remove"
     *          }
     *     },
     *     parameters={
     *         {"name"="title", "dataType"="string", "required"=true, "description"="post title"},
     *     },
     *     statusCodes = {
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Delete("post/delete", name="post_delete")
     */
    public function deletePostAction(Request $request)
    {
        var_dump($request->getContent());
        var_dump($request->get('id'));
        die;
        return $this->returnSuccessResponse('Filed');
    }
}
