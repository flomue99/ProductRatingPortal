<?php

namespace Application\Interfaces;

interface RatingRepository
{
    public function getRatingsForProduct(int $productId): array; //of Rating entity
    public function getRatingsForUser(int $userId): array; //of Rating entity
    public function addRating(int $productId, int $userId, int $rating, string $comment): void;
    public function getRatingForUserAndProduct($userId, $productId): ?\Application\Entities\Rating;
    public function deleteRating($ratingId): void;
    public function updateRating(int $id, int $productId, int $userId, int $rating, string $comment): void;
}