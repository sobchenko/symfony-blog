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
     * @Rest\Post("post/create", name="post_create")
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
