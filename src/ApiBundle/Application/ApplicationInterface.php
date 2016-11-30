<?php

namespace ApiBundle\Application;

interface ApplicationInterface
{
    /**
     * Create entity from JSON and save it.
     *
     * @param string $content - in json format
     */
    public function createFromJson($content);

    /**
     * @param object $entity
     */
    public function save($entity);
}
