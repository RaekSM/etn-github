<?php

namespace App;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Branche extends \Kdyby\Doctrine\Entities\BaseEntity
{
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", name="commit_url")
     */
    protected $commitUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Repository", inversedBy="branches")
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
        return $this->commitUrl;
    }

    /**
     * @param mixed $commitUrl
     */
    public function setCommitUrl($commitUrl)
    {
        $this->commitUrl = $commitUrl;
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