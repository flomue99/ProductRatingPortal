<?php

namespace Application\Interfaces;

interface UserRepository
{
    public function getUserForId(int $id): ?\Application\Entities\User;
    public function getUserForUsername(string $userName): ?\Application\Entities\User;
    public function createUser(string $userName, string $password): void;
}