<?php

namespace Application\DAO;

class ProductData
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $manufacturer,
        public int    $createdBy,
        public string $createdByUserName,
        public string $description,
        public int    $amountOfRatings,
        public float  $averageRating)
    {
    }
}