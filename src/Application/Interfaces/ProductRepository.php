<?php

namespace Application\Interfaces;

interface ProductRepository
{
    public function getAllProductsForFilter( $searchString): array; //of Product entity
    public function getAllProductsForUserAndFilter($userId, $searchString): array; //of Product entity
    public function createProduct($userId, $name, $manufacturer, $description): void;
    public function updateProduct($id, $userId, $name, $manufacturer, $description): void;
    public function getProductForId($productId): ?\Application\Entities\Product;

}