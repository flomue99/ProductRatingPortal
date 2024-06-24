<?php

namespace Application\Services;

class UserService
{
    public function __construct(private \Application\Interfaces\UserRepository $userRepository)
    {
    }

    public function getUsernameForUserId(int $userId): string
    {
        $user = $this->userRepository->getUserForId($userId);
        return $user->getUsername();
    }

}