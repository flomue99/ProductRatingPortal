<?php

namespace Application;

class DeleteRatingCommand
{
    public function __construct(
        private Interfaces\RatingRepository $ratingRepository,
        private Services\UserService $userService)
    {
    }
    public function execute(int $ratingId): void
    {
        $this->ratingRepository->deleteRating($ratingId);
    }
}