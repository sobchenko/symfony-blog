<?php

namespace ApiBundle\Application;

use BlogBundle\Entity\Post;
use JMS\Serializer\Serializer;
use BlogBundle\Domain\BasicInterface as BasicDomainInterface;

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
     * @return string
     */
    protected function getEntityName()
    {
        return Post::class;
    }
}
