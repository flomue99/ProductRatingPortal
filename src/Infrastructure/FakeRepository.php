<?php

namespace Infrastructure;

class FakeRepository
    implements
    \Application\Interfaces\UserRepository
{
    private $mockUsers;

    public function __construct()
    {

        $this->mockUsers = array(
            array(1, 'scr4', '$2y$10$0dhe3ngxlmzgZrX6MpSHkeoDQ.dOaceVTomUq/nQXV0vSkFojq.VG')
        );
    }

    public function getUserForId(int $id): ?\Application\Entities\User
    {
       foreach ($this->mockUsers as $u){
           if($u[0] === $id){
               return new \Application\Entities\User($u[0], $u[1], $u[2]);
           }
       }
       return null;
    }

    public function getUserForUsername(string $userName): ?\Application\Entities\User
    {
        foreach ($this->mockUsers as $u){
            if($u[1] === $userName){
                return new \Application\Entities\User($u[0], $u[1], $u[2]);
            }
        }
        return null;
    }

}
