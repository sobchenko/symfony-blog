<?php

namespace ApiBundle\Application;

use BlogBundle\Entity\Post;
use JMS\Serializer\Serializer;
use BlogBundle\Domain\BasicInterface as BasicDomainInterface;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Posts extends AbstractApplication
{
    public function __construct(Serializer $serializer, BasicDomainInterface $service)
    {
        parent::__construct($serializer, $service);
    }

    /**
     * {@inheritdoc}
     */
    public function createFromJson($content)
    {
        /** @var Post $entity */
        $entity = $this->deserialize($content);
        parent::save($entity);
    }

    /**
     * @param $id
     */
    public function removeById($id)
    {
        $service = $this->getService();
        $entity = $service->loadById($id);
        if (empty($entity)) throw new GoneHttpException("Post with id: '{$id}' already deleted");
        $service->remove($entity);
    }

    /**
     * @param $id
     * @return Post
     */
    public function getById($id)
    {
        $service = $this->getService();
        return $service->loadById($id);
    }

    /**
     * @return array Post
     */
    public function getAll()
    {
        $service = $this->getService();
        return $service->loadAll();
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Post::class;
    }
}
