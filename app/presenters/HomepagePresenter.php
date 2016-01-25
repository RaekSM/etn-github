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
				$this->flashMessage('User not found', 'error');
			} elseif ($this->returnData['error'] == 2) {
				$this->flashMessage('Doctrine error, data not save', 'error');
			}
		}else{
			$this->redirect('ShowSearch:',$this->returnData);
		}
	}

	public function renderDefault()
	{

	}
}