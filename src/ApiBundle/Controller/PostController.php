<?php

namespace ApiBundle\Controller;

use ApiBundle\Application\Posts;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends AbstractJsonController
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Get collection of blog posts",
     *     statusCodes = {
     *         200 = "OK"
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Get("post", name="post_list")
     */
    public function listPostAction()
    {
        try {
            $service = $this->getPostService();
            $statusCode = AbstractJsonController::HTTP_STATUS_CODE_OK;
            $posts = $service->getAll();
            if (empty($posts)) {
                $statusCode = AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT;
                $posts = [];
            }

            return $this->createSuccessfulResponse($posts, $statusCode);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Create new blog post",
     *     parameters={
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post Title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post Shot Description"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post Content"},
     *     },
     *     statusCodes = {
     *         201 = "Successfully created",
     *         500 = "Error - Internal"
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

            return $this->createSuccessfulResponse([], AbstractJsonController::HTTP_STATUS_CODE_CREATED);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Get blog post with id",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "required"=true,
     *              "description"="post id"
     *          }
     *     },
     *     statusCodes = {
     *         200 = "Success",
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     *
     * @Rest\Get("post/{id}", name="post_get", requirements={"id" = "\d+"})
     */
    public function getPostAction($id)
    {
        try {
            $service = $this->getPostService();
            $statusCode = AbstractJsonController::HTTP_STATUS_CODE_OK;
            $post = $service->getById($id);
            if (empty($post)) {
                $statusCode = AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT;
                $post = [];
            }

            return $this->createSuccessfulResponse($post, $statusCode);
        } catch (NotFoundHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_NOT_FOUND);
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
     *              "description"="post id to delete"
     *          }
     *     },
     *     statusCodes = {
     *         204 = "Success - No content",
     *         404 = "Error - Not found",
     *         410 = "Error - Gone, post already deleted",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Delete("post/{id}", name="post_delete", requirements={"id" = "\d+"})
     */
    public function deletePostAction($id)
    {
        try {
            $service = $this->getPostService();
            $service->removeById($id);

            return $this->createSuccessfulResponse([], AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT);
        } catch (GoneHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_GONE);
        } catch (NotFoundHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
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
     *              "description"="post id to put"
     *          }
     *     },
     *     parameters={
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post Title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post Shot Description"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post Content"},
     *     },
     *     statusCodes = {
     *         204 = "Success - No content",
     *         404 = "Error - Not found",
     *         410 = "Error - Gone, post already deleted",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Put("post/{id}", name="post_put", requirements={"id" = "\d+"})
     */
    public function putPostAction(Request $request, $id)
    {
        try {
            $postId = (int) $id;
            if ($postId == 0) {
                throw new NotFoundHttpException('Post id cann\'t be empty');
            }
            $service = $this->getPostService();
            $statusCode = AbstractJsonController::HTTP_STATUS_CODE_OK;
            $post = $service->getById($id);
            if (empty($post)) {
                $statusCode = AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT;
                $post = [];
            }

            return $this->createSuccessfulResponse($post, $statusCode);
        } catch (NotFoundHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
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
     *              "description"="post id to patch"
     *          }
     *     },
     *     parameters={
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post Title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post Shot Description"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post Content"},
     *     },
     *     statusCodes = {
     *         204 = "Success - No content",
     *         404 = "Error - Not found",
     *         410 = "Error - Gone, post already deleted",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Patch("post/{id}", name="post_patch", requirements={"id" = "\d+"})
     */
    public function patchPostAction(Request $request, $id)
    {
        try {
            $service = $this->getPostService();
            $statusCode = AbstractJsonController::HTTP_STATUS_CODE_OK;
            $post = $service->getById($id);
            if (empty($post)) {
                $statusCode = AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT;
                $post = [];
            }

            return $this->createSuccessfulResponse($post, $statusCode);
        } catch (NotFoundHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * @return Posts
     */
    private function getPostService()
    {
        return $this->get('blog.api.application.posts');
    }
}
