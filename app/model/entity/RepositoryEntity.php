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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $full_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $html_url_user;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $html_url_repo;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pushed_at;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $clone_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $default_branch;

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
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrlUser()
    {
        return $this->html_url_user;
    }

    /**
     * @param mixed $html_url_user
     */
    public function setHtmlUrlUser($html_url_user)
    {
        $this->html_url_user = $html_url_user;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrlRepo()
    {
        return $this->html_url_repo;
    }

    /**
     * @param mixed $html_url_repo
     */
    public function setHtmlUrlRepo($html_url_repo)
    {
        $this->html_url_repo = $html_url_repo;
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
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getPushedAt()
    {
        return $this->pushed_at;
    }

    /**
     * @param mixed $pushed_at
     */
    public function setPushedAt($pushed_at)
    {
        $this->pushed_at = $pushed_at;
    }

    /**
     * @return mixed
     */
    public function getCloneUrl()
    {
        return $this->clone_url;
    }

    /**
     * @param mixed $clone_url
     */
    public function setCloneUrl($clone_url)
    {
        $this->clone_url = $clone_url;
    }

    /**
     * @return mixed
     */
    public function getDefaultBranch()
    {
        return $this->default_branch;
    }

    /**
     * @param mixed $default_branch
     */
    public function setDefaultBranch($default_branch)
    {
        $this->default_branch = $default_branch;
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