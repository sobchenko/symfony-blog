<?php

namespace ApiBundle\Application;

use BlogBundle\Entity\Post;
use JMS\Serializer\Serializer;
use BlogBundle\Domain\BasicInterface as BasicDomainInterface;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class Posts extends AbstractApplication
{
    public function __construct(Serializer $serializer, BasicDomainInterface $service)
    {
        parent::__construct($serializer, $service);
    }

    /**
     * Create new entity from JSON.
     *
     * @param string $data
     *
     * @return object
     */
    public function createFromJson($data)
    {
        return $this->deserialize($data);
    }

    /**
     * Update existing entity from JSON.
     *
     * @param string $data
     * @param $entity
     *
     * @return Post
     */
    public function updateFromJson($data, $entity)
    {
        return $this->deserialize($data, $entity);
    }

    /**
     * @param $id
     */
    public function removeById($id)
    {
        /** @var \BlogBundle\Domain\Posts $service */
        $service = $this->getService();
        $entity = $service->loadById($id);
        if (empty($entity)) {
            throw new GoneHttpException("Post with id: '{$id}' not exists");
        }
        $service->remove($entity);
    }

    /**
     * @param $id
     *
     * @return Post
     */
    public function getById($id)
    {
        /** @var \BlogBundle\Domain\Posts $service */
        $service = $this->getService();

        return $service->loadById($id);
    }

    /**
     * @return array Post
     */
    public function getAll()
    {
        /** @var \BlogBundle\Domain\Posts $service */
        $service = $this->getService();

        return $service->loadAll();
    }

    /**
     * @param $errors
     *
     * @return string
     */
    public function handleErrors($errors)
    {
        return $this->serialize($errors);
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Post::class;
    }
}
