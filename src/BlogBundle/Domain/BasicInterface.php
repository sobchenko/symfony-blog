<?php

namespace BlogBundle\Domain;

interface BasicInterface
{
    /**
     * Save entity.
     *
     * @param array|object $entity
     */
    public function save($entity);
}
