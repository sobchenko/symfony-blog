<?php

namespace BlogBundle\Repository;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;

class BasicRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function save($entity)
    {
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new \Exception('Duplication found in one of unique fields when saving entity.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function find($entityId)
    {
        return parent::find($entityId);
    }
}
