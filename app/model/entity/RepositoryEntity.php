<?php

namespace App;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Repository extends \Kdyby\Doctrine\Entities\BaseEntity
{
    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true, name="full_name")
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", nullable=true, name="html_url_user")
     */
    protected $htmlUrlUser;

    /**
     * @ORM\Column(type="string", nullable=true, name="html_url_repo")
     */
    protected $htmlUrlRepo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="updated_at")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="pushed_at")
     */
    protected $pushedAt;

    /**
     * @ORM\Column(type="string", nullable=true, name="clone_url")
     */
    protected $cloneUrl;

    /**
     * @ORM\Column(type="string", nullable=true, name="default_branch")
     */
    protected $defaultBranch;

    /**
     * @ORM\ManyToOne(targetEntity="Search", inversedBy="repositories")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $search;

    /**
     * @ORM\OneToMany(targetEntity="Branche", mappedBy="repository")
     */
    protected $branches;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="repository")
     */
    protected $tags;

    /**
     * @ORM\OneToMany(targetEntity="Commit", mappedBy="repository")
     */
    protected $commits;

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
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrlUser()
    {
        return $this->htmlUrlUser;
    }

    /**
     * @param mixed $htmlUrlUser
     */
    public function setHtmlUrlUser($htmlUrlUser)
    {
        $this->htmlUrlUser = $htmlUrlUser;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrlRepo()
    {
        return $this->htmlUrlRepo;
    }

    /**
     * @param mixed $htmlUrlRepo
     */
    public function setHtmlUrlRepo($htmlUrlRepo)
    {
        $this->htmlUrlRepo = $htmlUrlRepo;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getPushedAt()
    {
        return $this->pushedAt;
    }

    /**
     * @param mixed $pushedAt
     */
    public function setPushedAt($pushedAt)
    {
        $this->pushedAt = $pushedAt;
    }

    /**
     * @return mixed
     */
    public function getCloneUrl()
    {
        return $this->cloneUrl;
    }

    /**
     * @param mixed $cloneUrl
     */
    public function setCloneUrl($cloneUrl)
    {
        $this->cloneUrl = $cloneUrl;
    }

    /**
     * @return mixed
     */
    public function getDefaultBranch()
    {
        return $this->defaultBranch;
    }

    /**
     * @param mixed $defaultBranch
     */
    public function setDefaultBranch($defaultBranch)
    {
        $this->defaultBranch = $defaultBranch;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }


}