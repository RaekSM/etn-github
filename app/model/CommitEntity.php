<?php

namespace App;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Commit extends \Kdyby\Doctrine\Entities\BaseEntity
{
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $author;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $committer;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="Repository", inversedBy="commits")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $repository;

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCommitter()
    {
        return $this->committer;
    }

    /**
     * @param mixed $committer
     */
    public function setCommitter($committer)
    {
        $this->committer = $committer;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

}