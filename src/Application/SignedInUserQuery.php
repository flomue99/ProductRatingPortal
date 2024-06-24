<?php

namespace Application;

use Application\DAO\UserData;

class SignedInUserQuery
{
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository      $userRepository
    )
    {
    }

    public function execute(): ?UserData
    {
        $userId = $this->authenticationService->getUserId();
        if ($userId === null) {
            return null;
        }
        $user = $this->userRepository->getUserForId($userId);
        if ($user === null) {
            return null;
        }

        return new UserData($user->getId(), $user->getUsername());
    }
}