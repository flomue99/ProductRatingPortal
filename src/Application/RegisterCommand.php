<?php

namespace Application;

class RegisterCommand
{
    const EMPTY_USERNAME = 0x01;
    const EMPTY_PASSWORD = 0x02;
    const PASSWORDS_DO_NOT_MATCH = 0x04;
    const USER_ALREADY_EXISTS = 0x08;


    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository $userRepository
    )
    {
    }

    public function execute(string $userName,  string $password, string $repeatPassword): int
    {
        //make sure that previous user is signed out
        $this->authenticationService->signOut();

        $errors = 0;

        //check if username is empty
        if($userName === '') {
            $errors |= self::EMPTY_USERNAME;
        }

        //check if password is empty
        if($password === '' || $repeatPassword === '') {
            $errors |= self::EMPTY_PASSWORD;
        }

        //check if there is a user with the same username
        $user = $this->userRepository->getUserForUsername($userName);
        if($user !== null) {
            $errors |= self::USER_ALREADY_EXISTS;
        }
        //check if passwords match
        if($password !== $repeatPassword) {
            $errors |= self::PASSWORDS_DO_NOT_MATCH;
        }

        if($errors !== 0) {
            return $errors;
        }

        //register user
        $this->userRepository->createUser($userName, $password);

        //login the user
        //get new created user
        $user = $this->userRepository->getUserForUsername($userName);
        $this->authenticationService->signIn($user->getId());

        return 0;
    }
}