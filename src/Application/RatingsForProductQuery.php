<?php

namespace Application;

use Application\DAO\RatingData;

class RatingsForProductQuery
{
    public function __construct(
        private Interfaces\RatingRepository $ratingRepository,
        private Services\UserService $userService)
    {
    }

    public function execute(int $productId): array //of RatingData
    {
        $res = [];
        foreach ($this->ratingRepository->getRatingsForProduct($productId) as $r) {
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