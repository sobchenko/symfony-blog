<?php

namespace ApiBundle\Controller;

use ApiBundle\Application\Posts;
use BlogBundle\Entity\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PostController extends AbstractJsonController
{
    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Get collection of blog posts",
     *     statusCodes = {
     *         200 = "OK",
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Get("post", name="post_list")
     *
     * @return Response
     */
    public function listPostAction()
    {
        try {
            $service = $this->getPostService();
            $posts = $service->getAll();
            $statusCode = AbstractJsonController::HTTP_STATUS_CODE_OK;
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
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createPostAction(Request $request)
    {
        try {
            $service = $this->getPostService();
//            throw new UnprocessableEntityHttpException(print_r($request, true));
            $post = $service->createFromJson($request->getContent());
            $this->validate($post, $service);
            $service->save($post);

            return $this->createSuccessfulResponse($post, AbstractJsonController::HTTP_STATUS_CODE_CREATED);
        } catch (UnprocessableEntityHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_INTERNAL_ERROR);
        }
    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="Get blog post with id",
     *     statusCodes = {
     *         200 = "Success",
     *         204 = "Success - No content",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     *
     * @Rest\Get("post/{id}", name="post_get", requirements={"id" = "\d+"})
     *
     * @param int $id Post ID to get
     *
     * @return Response
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
     *
     * @param int $id Post ID to delete
     *
     * @return Response
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
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post Title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post Shot Description"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post Content"}
     *     },
     *     statusCodes = {
     *         204 = "Success - Post is updated",
     *         404 = "Error - Not found",
     *         410 = "Error - Gone, post doesn't exist",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Put("post/{id}", name="post_put", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id      Post ID to put
     *
     * @return Response
     */
    public function putPostAction(Request $request, $id)
    {
        try {
            $service = $this->getPostService();
            $post = $service->getById($id);
            if (empty($post)) {
                throw new GoneHttpException("Resource with id:'{$id}' doesn't exist");
                // TODO  Should we create entity if it is not exist 201 = "Success - Post is created",
            }
            // TODO -> why line bellow (updateFromJson) does not work? It should work like sending $post should be updated???
            $postNew = $service->updateFromJson($request->getContent(), $post);
            $this->validate($postNew, $service);
            $post->setPostTitle($postNew->getPostTitle());
            $post->setPostContent($postNew->getPostContent());
            $post->setPostDescription($postNew->getPostDescription());
            $service->save($post);

            return $this->createSuccessfulResponse([], AbstractJsonController::HTTP_STATUS_CODE_NO_CONTENT);
        } catch (GoneHttpException $e) {
            return $this->createFailedResponse($e, AbstractJsonController::HTTP_STATUS_CODE_NOT_FOUND);
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
     *     parameters={
     *         {"name"="post_title", "dataType"="string", "required"=true, "description"="Post Title"},
     *         {"name"="post_description", "dataType"="string", "required"=true, "description"="Post Shot Description"},
     *         {"name"="post_content", "dataType"="textarea", "required"=false, "description"="Post Content"},
     *     },
     *     statusCodes = {
     *         204 = "Success - ",
     *         404 = "Error - Not found",
     *         410 = "Error - Gone, post doesn't exist",
     *         500 = "Error - Internal"
     *     },
     *     section="Blog Post"
     * )
     * @Rest\Patch("post/{id}", name="post_patch", requirements={"id" = "\d+"})
     *
     * @param Request $request
     * @param int     $id      Post ID to patch
     *
     * @return Response
     */
    public function patchPostAction(Request $request, $id)
    {
        try {
            $service = $this->getPostService();
            $post = $service->getById($id);
            if (empty($post)) {
                throw new GoneHttpException("Resource with id:'{$id}' doesn't exist");
            }
            // Based on assumption that existed entity is valid
            $postNew = $service->createFromJson($request->getContent());
            // TODO should work something like this but necessary to refactor bellow part

            //validateProperty
            if ($postNew->getPostTitle()) {
                $post->setPostTitle($postNew->getPostTitle());
            }
            $post->setPostContent($postNew->getPostContent());
            $post->setPostDescription($postNew->getPostDescription());

            $this->validate($post, $service);
            $service->save($post);

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
     * @param Post  $post
     * @param Posts $service
     *
     * @throws NotAcceptableHttpException
     */
    private function validate($post, $service)
    {
        $errors = $this->get('validator')->validate($post);
        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException($service->handleErrors($errors));
        }
    }

    /**
     * @param Post   $post
     * @param Posts  $service
     * @param string $propertyName
     *
     * @throws NotAcceptableHttpException
     */
    private function validateProperty($post, $service, $propertyName)
    {
        $errors = $this->get('validator')->validateProperty($post, $propertyName);
        if (count($errors) > 0) {
            throw new UnprocessableEntityHttpException($service->handleErrors($errors));
        }
    }

    /**
     * @return Posts ApiBundle/Application
     */
    private function getPostService()
    {
        return $this->get('blog.api.application.posts');
    }
}
