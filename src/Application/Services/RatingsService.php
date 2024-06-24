<?php

namespace Application\Services;

class RatingsService
{
    public function __construct(private \Application\Interfaces\RatingRepository $ratingRepository)
    {
    }

    public function getAmountOfRatings(int $productId): int
    {
        $ratings = $this->ratingRepository->getRatingsForProduct($productId);
        return count($ratings);
    }

    public function getAverageRating(int $productId): float
    {
        $ratings = $this->ratingRepository->getRatingsForProduct($productId);
        //if there are no ratings, return 0
        if (count($ratings) == 0) {
            return 0;
        }
        $sum = 0;
        foreach ($ratings as $r) {
            $sum += $r->getRating();
        }
        return $sum / count($ratings);
    }

    public function ratingForUserAndProductExits(int $userId, int $productId): bool
    {
        $rating = $this->ratingRepository->getRatingForUserAndProduct($userId, $productId);
        if ($rating == null) {
            return false;
        }
        return true;
    }
}