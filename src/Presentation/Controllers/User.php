<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller
{

    public function __construct(
        private \Application\SignInCommand     $signInCommand,
        private \Application\SignOutCommand    $signOutCommand,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\RegisterCommand   $registerCommand
    )
    {
    }

    public function GET_LogIn(): \Presentation\MVC\ActionResult
    {
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(),
            'userName' => ''
        ]);
    }

    public function GET_Register(): \Presentation\MVC\ActionResult
    {
        return $this->view('register', [
            'user' => $this->signedInUserQuery->execute(),
            'userName' => ''
        ]);
    }

    public function POST_Register(): \Presentation\MVC\ActionResult
    {
        $result = $this->registerCommand->execute($this->getParam('un'), $this->getParam('pwd'), $this->getParam('rPwd'));

        if ($result != 0) {
            $errors = [];

            if ($result & \Application\RegisterCommand::EMPTY_USERNAME) {
                $errors[] = 'Username cannot be empty!';
            }
            if ($result & \Application\RegisterCommand::EMPTY_PASSWORD) {
                $errors[] = 'Password cannot be empty!';
            }
            if ($result & \Application\RegisterCommand::PASSWORDS_DO_NOT_MATCH) {
                $errors[] = 'Passwords do not match!';
            }
            if ($result & \Application\RegisterCommand::USER_ALREADY_EXISTS) {
                $errors[] = 'User with this username already exists!';
            }
            if (sizeof($errors) == 0) {
                $errors[] = 'An error occurred. Please try again.';
            }

            return $this->view('register', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => $errors
            ]);

        }
        return $this->redirect('Home', 'Index');
    }

    public function POST_LogIn(): \Presentation\MVC\ActionResult
    {
        $ok = $this->signInCommand->execute($this->getParam('un'), $this->getParam('pwd'));
        if (!$ok) {
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => ["Invalid user name or password!"]
            ]);
        }

        return $this->redirect('Home', 'Index');

    }

    public function POST_LogOut(): \Presentation\MVC\ActionResult
    {
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index');
    }

}