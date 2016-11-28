<?php

namespace ApiBundle\Application;

use BlogBundle\Domain\BasicInterface as BasicDomainInterface;
use JMS\Serializer\Serializer;

abstract class AbstractApplication implements ApplicationInterface
{
    /**
     * @var BasicDomainInterface
     */
    protected $service;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @param Serializer           $serializer
     * @param BasicDomainInterface $service
     */
    public function __construct(Serializer $serializer, BasicDomainInterface $service)
    {
        $this->serializer = $serializer;
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromJson($content)
    {
        $entity = $this->deserialize($content);
        $this->save($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function save($entity)
    {
        $this->service->save($entity);
    }

    /**
     * @param $content
     *
     * @return object
     */
    protected function deserialize($content)
    {
        return $this->serializer->deserialize($content, $this->getEntityName(), 'json');
    }

    /**
     * @return BasicDomainInterface
     */
    protected function getService()
    {
        return $this->service;
    }

    /**
     * @return Serializer
     */
    protected function getSerializer()
    {
        return $this->serializer;
    }

    abstract protected function getEntityName();
}
