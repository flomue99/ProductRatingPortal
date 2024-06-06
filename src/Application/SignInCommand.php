<?php

namespace Application;

class SignInCommand
{
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository      $userRepository,
    )
    {
    }

    public function execute(string $userName, string $password): bool
    {
        //make sure that previous user is signed out
        $this->authenticationService->signOut();

        //check if user exists
        $user = $this->userRepository->getUserForUsername($userName);
        if ($user === null) {
            return false;
        }
        //check if password is correct
        if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        //login user
        $this->authenticationService->signIn($user->getId());
        return true;
    }
}