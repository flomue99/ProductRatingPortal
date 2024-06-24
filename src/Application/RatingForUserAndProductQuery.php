<?php

namespace Application;

use Application\DAO\RatingData;

class RatingForUserAndProductQuery
{

    public function __construct(
        private Interfaces\RatingRepository $ratingRepository,
        private Services\UserService        $userService)
    {
    }

    public function execute($userId, $productId): ?\Application\DAO\RatingData //of RatingData
    {
        $r = $this->ratingRepository->getRatingForUserAndProduct($userId, $productId);
        $res = new RatingData(
            $r->getId(),
            $r->getUserId(),
            $r->getProductId(),
            $this->userService->getUsernameForUserId($r->getUserId()),
            $r->getRating(),
            $r->getComment(),
            $r->getCreatedAt(),
        );
        return $res;
    }
}