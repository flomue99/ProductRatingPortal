<?php

namespace Application;

class UpdateRatingCommand
{
    const ERROR_RATING_GRADE_REQUIRED = 0x01;
    const ERROR_RATING_GRADE_MUST_BE_INT = 0x02;
    const ERROR_USER_NOT_AUTHENTICATED = 0x04;

    public function __construct(
        private Interfaces\RatingRepository    $ratingRepository,
        private Services\AuthenticationService $authenticationService
    )
    {
    }

    public function execute($id, $productId, $rating, $comment): int
    {
        $errors = 0;
        //check if current user is authenticated
        $userId = $this->authenticationService->getUserId();
        if ($userId === null) {
            $errors |= self::ERROR_USER_NOT_AUTHENTICATED;
        }

        //check if rating is empty
        if ($rating === '' || $rating === null) {
            $errors |= self::ERROR_RATING_GRADE_REQUIRED;
        }

        //check if rating is between 1 and 5
        if ($rating < 1 || $rating > 5) {
            $errors |= self::ERROR_RATING_GRADE_MUST_BE_INT;
        }

        if ($errors !== 0) {
            return $errors;
        }

        $this->ratingRepository->updateRating($id, $productId, $userId, $rating, $comment);

        return 0;

    }
}