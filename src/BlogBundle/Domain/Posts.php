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
        /** @var PostRepository $repo */
        $repo = $this->getRepository();

        return $repo->findAll();
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function loadById($id)
    {
        /** @var PostRepository $repo */
        $repo = $this->getRepository();

        return $repo->find($id);
    }
}
