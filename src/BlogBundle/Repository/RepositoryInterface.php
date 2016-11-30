<?php

namespace BlogBundle\Repository;

interface RepositoryInterface
{
    /**
     * @param object $entity
     */
    public function save($entity);
}
