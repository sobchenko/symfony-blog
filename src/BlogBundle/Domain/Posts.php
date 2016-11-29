<?php

namespace BlogBundle\Domain;

use BlogBundle\Entity\User;
use BlogBundle\Repository\PostRepository;

class Posts extends Basic
{
    /**
     * @param integer $id
     *
     * @return User
     */
    public function loadById($id)
    {
        /** @var PostRepository $repo */
        $repo = $this->getRepository();
        return $repo->find($id);
    }
}
