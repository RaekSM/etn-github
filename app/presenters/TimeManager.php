<?php

namespace App\Presenters;

use App\Search;
use Nette;
use App\Model,
    Nette\Application\UI;


class TimeManagerPresenter extends BasePresenter
{

    /** @var \App\Model\UserManager @inject */
    public $userManager;

    /** @var \App\Model\TimeDelete @inject */
    public $deleter;

    protected function startup()
    {
        parent::startup();
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Login:');
        }
    }

    /*
     * Create component for timemanagement form
     *
     */
    protected function createComponentTimeForm()
    {

        $form = new UI\Form;

        // add text input for hours - hours must be number
        $form->addText('hours', 'Hours')
            ->addRule($form::FLOAT, 'Enter value must be number!')
            ->setRequired("Enter hours!");


        // treatment component and push data to function timeFormSucceeded
        $form->addSubmit('send');
        $form->onSuccess[] = array($this, 'timeFormSucceeded');
        return $form;
    }

    /*
     * Method for treatment form component
     */
    public function timeFormSucceeded($form, $values)
    {
        // call funtion for delete rows
        $numberDeleted = $this->deleter->delete($values->hours);

        // control deleted rows
        if($numberDeleted){
            $this->flashMessage('Deleted ' . $numberDeleted . ' rows ...');
        } else {
            $this->flashMessage('Nothing to delete!', 'error');
        }

        // redirect after
        $this->redirect('TimeManager:');
    }

    public function renderDefault()
    {

    }

}
