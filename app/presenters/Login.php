<?php

namespace App\Presenters;

use Nette;
use App\Model,
    Nette\Application\UI;


class LoginPresenter extends BasePresenter
{

    /** @var \App\Model\UserManager @inject */
    public $userManager;

    protected function startup()
    {
        parent::startup();
        if ($this->user->isLoggedIn()) {
        }
    }

    /*
     * Create component for login form
     *
     */
    protected function createComponentLoginForm()
    {

        $form = new UI\Form;

        // add text input for login
        $form->addText('login', 'Login')
            ->setRequired("Enter login!");
        // add password input
        $form->addPassword('password', 'Password')
            ->setRequired('Enter your password!');


        // treatment component and push data to function loginFormSucceeded
        $form->addSubmit('send');
        $form->onSuccess[] = array($this, 'loginFormSucceeded');
        return $form;
    }

    /*
     * Method for treatment form component
     */
    public function loginFormSucceeded($form, $values)
    {
        $this->user->setExpiration('10 minutes', TRUE);
        try
        {
            // login user
            $this->user->login($values->login, $values->password);
            $this->redirect('TimeManager:');
        }
        catch (Nette\Security\AuthenticationException $e)
        {
            $form->addError($e->getMessage());
        }

    }

    public function renderDefault()
    {

    }

    public function actionLogOut()
    {
        $this->user->logout();
        $this->redirect('Login:');
    }

}
