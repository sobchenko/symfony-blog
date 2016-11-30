<?php

namespace ApiBundle\Application;

use BlogBundle\Domain\BasicInterface as BasicDomainInterface;
use JMS\Serializer\DeserializationContext;
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
     * Deserialize the data "on to" to the existing entity (if not empty) or create a new one;.
     *
     * @param $data
     * @param object
     *
     * @return object
     */
    protected function deserialize($data, $entity = null)
    {
        $context = new DeserializationContext();
        if (!empty($entity)) {
            $context->attributes->set('target', $entity);
        }

        return $this->serializer->deserialize($data, $this->getEntityName(), 'json', $context);
    }

    /**
     * @param $content
     *
     * @return string
     */
    protected function serialize($content)
    {
        return $this->serializer->serialize($content, 'json');
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
