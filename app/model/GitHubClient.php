<?php

namespace App\Model;

use Nette;

/**
 * Class of GitHub client connection.
 */
class GitHubClient extends Nette\Object
{
    // define constants
    const
        BASEURL     = 'https://api.github.com/',
        USERURL     = 'https://api.github.com/users/';


    /**
     * @var \Nette\Http\Request
     */
    private $request;

    /*
     * Declare classic properties
     */
    protected $ch;

    protected $accestoken;

    // inject doctrine entity mamager to object
    public function __construct($accestoken, \Nette\Http\Request $httpRequest)
    {
        $this->accestoken = $accestoken;
        $this->request = $httpRequest;

        // init curn and check extension is available
        $this->ch = curl_init();
        if (!$this->ch) {
            throw new RuntimeException('Curl extension not install');
        }
    }

    /*
     * Gete data repositories
     *
     * @param string $search search string from form
     *
     * @return object
     */
    public function getRepository($search = null)
    {
        $repositoryUrl = self::USERURL . $search . '/repos';
        return $this->gitHubCurl($repositoryUrl);
    }

    /*
     * Gete data branches
     *
     * @param string $url url for get data
     *
     * @return object
     */
    public function getBranches($url)
    {
        $brancheUrl = str_replace('{/branch}', '', $url);
        return $this->gitHubCurl($brancheUrl);
    }

    /*
     * Gete data tags
     *
     * @param string $url url for get data
     *
     * @return object
     */
    public function getTags($url)
    {
        $tagsUrl = $url;
        return $this->gitHubCurl($tagsUrl);
    }

    /*
     * Gete data commits
     *
     * @param string $url url for get data
     *
     * @return object
     */
    public function getCommits($url)
    {
        $commitUrl = str_replace('{/sha}', '', $url);
        return $this->gitHubCurl($commitUrl);
    }

    /*
     * Method parsing data from github json
     *
     * @param json $data data in json format
     *
     * @return stdClass
     */
    public function parseData($data)
    {
        return json_decode($data);
    }

    /*
     * Method get data (jsonformat) from github
     *
     * @param string $url
     * @param mixed $key
     *
     * @return object
     */
    public function gitHubCurl($url)
    {
        $url = $url . '?access_token=' . self::ACCESTOKEN;

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        return $this->parseData(curl_exec($this->ch));
    }

// class end
}