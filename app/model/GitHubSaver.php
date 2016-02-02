<?php

namespace App\Model;

use App\Branche;
use App\Commit;
use App\Repository;
use App\Search;
use App\Tag;
use Nette;
use Symfony\Component\Console\Exception\RuntimeException;

/**
 * Class of GitHub data saver
 */
class GitHubSaver extends Nette\Object
{
    /**
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $em;

    /**
     * @var \Nette\Http\Request
     */
    private $request;

    /**
     * @var \App\Model\GitHubClient
     */
    private $ghc;

    //declared property of class
    public $repository;
    public $status = array();
    public $options;
    public $search;

    // inject doctrine entity mamager to object
    public function __construct(\Kdyby\Doctrine\EntityManager $entityManager, \Nette\Http\Request $httpRequest, \App\Model\GitHubClient $client)
    {
        $this->em       = $entityManager;
        $this->request  = $httpRequest;
        $this->ghc      = $client;
    }

    /*
     * Method for prepare data to save
     *
     * @param string $search search string from form
     * @param int $options options from form
     *
     * @return mixed
     */
    public function prepare($serach, $options = null)
    {
        // no error
        $this->status['error'] = false;
        $this->options = $options;
        $this->repository = $this->ghc->getRepository($serach);

        // when user repository for user not found
        if (isset($this->repository->message) && $this->repository->message == "Not Found"){
            $this->status['error'] = 1;
            // save only serach term and other
            $this->status['data'] = $this->doctrineFlush($this->saveData($serach));
            return $this->status;
        } elseif (is_null($this->repository)) {
            // when in username bad char, github api show 404 page
            $this->status['error'] = 2;
            // save only serach term and other
            $this->status['data'] = $this->doctrineFlush($this->saveData($serach));
            return $this->status;
        } elseif (empty($this->repository)) {
            // when return empty array
            $this->status['error'] = 3;
            // save only serach term and other
            $this->status['data'] = $this->doctrineFlush($this->saveData($serach));
            return $this->status;
        }

        // call method for prepare data to save data on db
        $this->search = $this->saveData($serach);
        // save other data, example repository and branches ...
        $this->saveOtherData($this->search);
        // call doctrine flush funtion
        $this->status['data'] = $this->doctrineFlush($this->search);
        // when doctrine save error
        if (!$this->status) {
            $this->status['error'] = 4;
            return $this->status;
        }
        return $this->status;

    }

    /*
     * Method for saving data to entites
     *
     * @param string $searchString search string from form
     *
     * @return mixed
     */
    public function saveData($searchString)
    {
        // get IP and actual Date
        $ip = $this->request->getRemoteAddress();
        // get datetime
        $date = new \DateTime();

        // new gneral entity
        $search = new Search();
        $search->setSearch($searchString);
        $search->setDate($date);
        $search->setIp($ip);

        $this->em->persist($search);

        return $search;
    }

    /*
     * Method for saving other data to entites
     *
     * @param object $searchString object search created
     *
     * @return void
     */
    public function saveOtherData($search) {

        // iterate over repositories and set repository entity
        foreach ($this->repository as $key => $value) {

            $dateCreatedAt = new \DateTime($value->created_at);
            $dateUpdatedAt = new \DateTime($value->updated_at);
            $datePushedAt = new \DateTime($value->pushed_at);

            $repository = new Repository();
            $repository->setName($value->name);
            $repository->setFullName($value->full_name);
            $repository->setHtmlUrlUser($value->owner->html_url);
            $repository->setHtmlUrlRepo($value->html_url);
            $repository->setDescription($value->description);
            $repository->setCreatedAt($dateCreatedAt);
            $repository->setUpdatedAt($dateUpdatedAt);
            $repository->setPushedAt($datePushedAt);
            $repository->setCloneUrl($value->clone_url);
            $repository->setDefaultBranch($value->default_branch);
            $repository->setSearch($search);

            // when options is set
            if ($this->options == 2) {
                // call save branches
                $this->saveBranches($value->branches_url, $repository);
            } elseif ($this->options == 3) {
                // call save branches
                $this->saveBranches($value->branches_url, $repository);
                // call save tags
                $this->saveTags($value->tags_url, $repository);
            } elseif ($this->options == 4) {
                // call save branches
                $this->saveBranches($value->branches_url, $repository);
                // call save tags
                $this->saveTags($value->tags_url, $repository);
                // call save commits
                $this->saveCommits($value->commits_url, $repository);
            }

            $this->em->persist($repository);
        }

        return;
    }

    /*
     * Method for saving data to branch entity
     *
     * @param string $branchesUrl url for branches
     * @param object $repository object repository
     *
     * @return void
     */
    public function saveBranches($branchesUrl, $repository)
    {
        //call gitHubClient for get stdObjects
        $branches = $this->ghc->getBranches($branchesUrl);

        // iterate over the array
        foreach ($branches as $branch) {
            $branche = new Branche();
            $branche->setName($branch->name);
            $branche->setCommitUrl($branch->commit->url);
            $branche->setRepository($repository);

            // preparing save entity
            $this->em->persist($branche);
        }

        return;
    }

    /*
     * Method for saving data to tag entity
     *
     * @param string $tagsUrl url for tags
     * @param object $repository object repository
     *
     * @return void
     */
    public function saveTags($tagsUrl, $repository)
    {
        //call gitHubClient for get stdObjects
        $tags = $this->ghc->getTags($tagsUrl);

        // iterate over the array
        foreach ($tags as $tagValue) {
            $tag = new Tag();
            $tag->setName($tagValue->name);
            $tag->setCommitUrl($tagValue->commit->url);
            $tag->setRepository($repository);

            // preparing save entity
            $this->em->persist($tag);
        }

        return;
    }

    /*
     * Method for saving data to commit entity
     *
     * @param string $commitsUrl url for commits
     * @param object $repository object repository
     *
     * @return void
     */
    public function saveCommits($commitsUrl, $repository)
    {
        //call gitHubClient for get stdObjects
        $commits = $this->ghc->getCommits($commitsUrl);

        // iterate over the array
        foreach ($commits as $commitValue) {
            if(isset($commitValue->commit)) {
                $commit = new Commit();
                $commit->setAuthor($commitValue->commit->author->name);
                $commit->setCommitter($commitValue->commit->committer->name);
                $commit->setMessage($commitValue->commit->message);
                $commit->setRepository($repository);

                // preparing save entity
                $this->em->persist($commit);
            }
        }

        return;
    }

    /*
     * Method for doctrine flush / save entity to database
     *
     * @param object $search object search
     *
     * @return int
     */
    public function doctrineFlush($search = null){
        // save entities
        if ($this->em->flush()) {
            // return last id
            return $search->getId();
        }

        // when error return false
        return false;
    }
}