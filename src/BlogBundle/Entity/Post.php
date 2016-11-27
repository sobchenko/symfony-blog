<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="post_title", type="string", length=100)
     */
    private $postTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="post_description", type="text")
     */
    private $postDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="post_content", type="text", nullable=true)
     */
    private $postContent;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set postTitle
     *
     * @param string $postTitle
     *
     * @return Post
     */
    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    /**
     * Get postTitle
     *
     * @return string
     */
    public function getPostTitle()
    {
        return $this->postTitle;
    }

    /**
     * Set postDescription
     *
     * @param string $postDescription
     *
     * @return Post
     */
    public function setPostDescription($postDescription)
    {
        $this->postDescription = $postDescription;

        return $this;
    }

    /**
     * Get postDescription
     *
     * @return string
     */
    public function getPostDescription()
    {
        return $this->postDescription;
    }

    /**
     * Set postContent
     *
     * @param string $postContent
     *
     * @return Post
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;

        return $this;
    }

    /**
     * Get postContent
     *
     * @return string
     */
    public function getPostContent()
    {
        return $this->postContent;
    }
}

