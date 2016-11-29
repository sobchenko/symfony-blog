<?php

namespace ApiBundle\Application;

use BlogBundle\Entity\Post;
use JMS\Serializer\Serializer;
use BlogBundle\Domain\BasicInterface as BasicDomainInterface;
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
        try {
            $service = $this->getService();
            $entity = $service->loadById($id);
            $service->remove($entity);
        } catch (\Exception $e) {
            // Do nothing
        }
    }

    /**
     * @return string
     */
    protected function getEntityName()
    {
        return Post::class;
    }
}
