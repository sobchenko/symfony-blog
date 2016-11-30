<?php

namespace BlogBundle\Domain;

use BlogBundle\Entity\Post;
use BlogBundle\Repository\PostRepository;

class Posts extends Basic
{
    /**
     * @return array Post collection
     */
    public function loadAll()
    {
        /** @var PostRepository $repository */
        $repository = $this->getRepository();

        return $repository->findAll();
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function loadById($id)
    {
        /** @var PostRepository $repo */
        $repository = $this->getRepository();

        return $repository->find($id);
    }
}
