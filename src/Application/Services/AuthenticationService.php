<?php

namespace Application\Services;
class AuthenticationService
{
    const USER_ID_KEY = 'userId';

    public function __construct(
        private \Application\Interfaces\Session $session,
    )
    {
    }

    public function getUserId(): ?int
    {
        return $this->session->get(self::USER_ID_KEY);
    }

    public function signOut(): void
    {
        $this->session->delete(self::USER_ID_KEY);
    }

    public function signIn(int $userId): void
    {
        $this->session->put(self::USER_ID_KEY, $userId);
    }

}