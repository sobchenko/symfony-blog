<?php

namespace BlogBundle\Domain;

use BlogBundle\Repository\RepositoryInterface;

class Basic implements BasicInterface
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function save($entity)
    {
        $this->getRepository()->save($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->getRepository()->remove($entity);
    }

    /**
     * @return RepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}
