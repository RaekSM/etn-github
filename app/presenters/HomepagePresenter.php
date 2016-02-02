<?php

namespace App\Presenters;

use Nette;
use App\Model,
	Nette\Application\UI;


class HomepagePresenter extends BasePresenter
{

	/**
	 * @var \App\Model\GitHubSaver @inject
	 */
	public $ghs;

	public $returnData;

	/*
	 * Create component for initial form
	 *
	 */
	protected function createComponentSearchForm()
	{
		// generate options
		$generalOptions = array(
			'1' => 'Repository',
			'2' => 'Repository and branches',
			'3' => 'Repository, branches and tags',
			'4' => 'Repository, branches, tags and commits',
		);

		$form = new UI\Form;

		// add textinput with validation
		$form->addText('search', 'Search term')
			->setRequired("Enter text for searching!")
			->addRule($form::MAX_LENGTH, 'The search text can be a maximum of %d characters', 40);
		// add radiolist with validation
		$form->addRadioList('generalOptions', 'General options:', $generalOptions)
			->setDefaultValue(true)
			->setRequired('Enter selections for options!');

		// treatment component and push data to function searchFormSucceeded
		$form->addSubmit('send');
		$form->onSuccess[] = $this->searchFormSucceeded;
		return $form;
	}

	/*
	 * Method for treatment form component
	 */
	public function searchFormSucceeded($form)
	{
		// load all values from form component
		$values = $form->getValues();
		// give data for prepare
		$this->returnData = $this->ghs->prepare(
			$values->search, $values->generalOptions
		);

		if(is_array($this->returnData)) {
			if ($this->returnData['error'] == 1) {
				$this->flashMessage('User not found, the search ordered', 'error');
			} elseif ($this->returnData['error'] == 2) {
				$this->flashMessage('User not found, most likely you entered illegal characters in username', 'error');
			} elseif ($this->returnData['error'] == 3) {
				$this->flashMessage('Repository for username not found', 'error');
			} elseif ($this->returnData['error'] == 4) {
				// data not save, redirect to form with error message
				$this->flashMessage('Doctrine error, data not save', 'error');
				$this->redirect('this');
			}

			// errors setted and data save, redirect to show search
			$this->redirect('ShowSearch:', $this->returnData['data']);
		}
	}

	public function renderDefault()
	{

	}
}