<?php

namespace ApiBundle\Controller;

use ApiBundle\Application\Posts;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractJsonController
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Show list of blog posts",
     *     statusCodes = {
     *          200 = "OK"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Get("post", name="post_get")
     */
    public function getPostAction()
    {
        return $this->createSuccessfulResponse([]);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Create new blog post",
     *     parameters={
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post title"},
     *     },
     *     statusCodes={
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Post("post", name="post_create")
     */
    public function createPostAction(Request $request)
    {
        try {
            $service = $this->getPostService();
            $service->createFromJson($request->getContent());

            return $this->createSuccessfulResponse([], AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="DELETE blog post with id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "required"=true,
     *              "description"="post id to remove"
     *          }
     *     },
     *     statusCodes = {
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Delete("post/{id}", name="post_delete")
     */
    public function deletePostAction(Request $request, $id)
    {
        return $this->createSuccessfulResponse([]);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="PUT blog post with id",
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
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post title"},
     *     },
     *     statusCodes = {
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Put("post/{id}", name="post_put")
     */
    public function putPostAction(Request $request, $id)
    {
        return $this->createSuccessfulResponse([]);
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="PATCH blog post with id",
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
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post title"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post title"},
     *     },
     *     statusCodes = {
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Patch("post/{id}", name="post_patch")
     */
    public function patchPostAction(Request $request, $id)
    {
        return $this->createSuccessfulResponse([]);
    }

    /**
     * @return Posts
     */
    private function getPostService()
    {
        return $this->get('blog.api.application.posts');
    }
}
