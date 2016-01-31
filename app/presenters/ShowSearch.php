<?php

namespace App\Presenters;

use App\Search;
use App\SearchQuery;
use Nette;
use App\Model,
    Nette\Application\UI;


class ShowSearchPresenter extends BasePresenter
{

    /**
     * @inject
     * @var \Kdyby\Doctrine\EntityManager
     */

    public $em;

    public function renderDefault($id)
    {
        if (!is_null($id)) {
            $search = $this->em->find(Search::getClassName(), $id);
            if (!$search) {
                $this->flashMessage('Data not found for this id', 'error');
                $this->redirect('Homepage:');
            }
        } else {
            $this->flashMessage('Data not found for this id', 'error');
        }
        $this->template->search = $search;

    }

}
