<?php
declare(strict_types=1);


namespace App\Presenters;

use Nette;
use Nette\Application\UI;
use Tracy\Debugger;
use Nette\Security\User;

final class UserPresenter extends Nette\Application\UI\Presenter
{
    // formulář pro registraci
    protected function createComponentRegistrationForm(): UI\Form
    {
        $form = new UI\Form;
        $form->addText('username', 'Jméno:');
        $form->addPassword('password', 'Heslo:');
        $form->addSubmit('login', 'Registrovat');
        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }

    // volá se po úspěšném odeslání formuláře registrace
    public function registrationFormSucceeded(UI\Form $form, \stdClass $values): void
    {
        $this->flashMessage('Byl jste úspěšně registrován. ' . $values->username);
        $this->redirect('Lorem:lorem');
    }

    // formulář pro login
    protected function createComponentLoginForm(): UI\Form
    {
        $form = new UI\Form;
        $form->addText('username', 'Jméno:');
        $form->addPassword('password', 'Heslo:');
        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        return $form;
    }

    // volá se po úspěšném odeslání formuláře login
    public function loginFormSucceeded(UI\Form $form, \stdClass $values): void
    {
        Debugger::barDump($values);

        try {
            $this->getUser()->login($values->username, $values->password);

            $this->redirect('Lorem:lorem');
            $this->flashMessage('Byl jste úspěšně prihlasen. ' . $values->username);

        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Špatný jméno nebo heslo.');
        }
    }

    // logout metoda
    public function actionLogout(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Lorem:lorem');
    }

    // login metoda
    public function actionLogin(): void
    {
        if ($this->getUser()->loggedIn){
            $this->flashMessage('Už jste přihlášen.');
            $this->redirect('Lorem:lorem');
        }
    }

    // register metoda
    public function actionRegister(): void
    {
        if ($this->getUser()->loggedIn){
            $this->flashMessage('Už jste přihlášen.');
            $this->redirect('Lorem:lorem');
        }
    }
}
