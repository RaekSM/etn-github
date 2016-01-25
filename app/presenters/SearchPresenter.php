<?php

namespace App\Presenters;

use App\Search;
use App\SearchQuery;
use Nette;
use App\Model,
    Nette\Application\UI;


class SearchPresenter extends BasePresenter
{
    const
        ROWSONPAGE = '4';

    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */

    public $em;

    public function renderDefault($page)
    {
        // initial dao object
        $dao = $this->em->getRepository(Search::getClassName());
        $searchQuery = new SearchQuery();

        // initial paginator
        $paginator = new Nette\Utils\Paginator;
        $paginator->setPage($page);
        $searchs = $dao->fetch($searchQuery)->applySorting(array('Search.date'=>'DESC'))->applyPaginator($paginator, self::ROWSONPAGE);
        $numberRows = $searchs->getTotalCount();
        $paginator->setItemCount($numberRows);

        // push data to template
        $this->template->search = $searchs;
        $this->template->paginator = $paginator;
        $this->template->page = $page;

    }

}
