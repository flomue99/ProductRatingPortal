<?php

namespace Application\DAO;

class UserData
{

    public function __construct(
        public int $id,
        public string $userName)
    {
    }
}