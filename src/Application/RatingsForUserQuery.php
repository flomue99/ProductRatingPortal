<?php

namespace Application;


use Application\DAO\RatingData;

class RatingsForUserQuery
{
    public function __construct(
        private Interfaces\RatingRepository $ratingRepository,
        private Services\UserService $userService)
    {
    }

    public function execute(int $userId): array //of RatingData
    {
        $res = [];
        foreach ($this->ratingRepository->getRatingsForUser($userId) as $r) {
            $res[] = new RatingData(
                $r->getId(),
                $r->getUserId(),
                $r->getProductId(),
                $this->userService->getUsernameForUserId($r->getUserId()),
                $r->getRating(),
                $r->getComment(),
                $r->getCreatedAt(),
            );
        }
        return $res;
    }
}