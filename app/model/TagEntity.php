<?php

namespace App;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Tag extends \Kdyby\Doctrine\Entities\BaseEntity
{
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $commit_url;

    /**
     * @ORM\ManyToOne(targetEntity="Repository", inversedBy="tags")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $repository;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCommitUrl()
    {
        return $this->commit_url;
    }

    /**
     * @param mixed $commit_url
     */
    public function setCommitUrl($commit_url)
    {
        $this->commit_url = $commit_url;
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