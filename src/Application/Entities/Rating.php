<?php

namespace Application\Entities;

class Rating
{
    public function __construct(
        private int $id,
        private int $userId,
        private int $productId,
        private int $rating,
        private string $comment,
        private string $createdAt)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}