<?php

namespace Application\DAO;

class RatingData
{

    public function __construct(
        public int $id,
        public int $userId,
        public int $productId,
        public string $userName,
        public int $rating,
        public string $comment,
        public string $createdAt)
    {
    }
}