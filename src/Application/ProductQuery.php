<?php

namespace Application;

use Application\DAO\ProductData;

class ProductQuery
{
    public function __construct(
        private Interfaces\ProductRepository $productRepository,
        private Services\RatingsService      $ratingsService,
        private Services\UserService         $userService)
    {
    }

    public function execute($productId): \Application\DAO\ProductData //of ProductData
    {

        $p = $this->productRepository->getProductForId($productId);
        $res = new ProductData(
            $p->getId(),
            $p->getName(),
            $p->getManufacturer(),
            $p->getCreatedBy(),
            $this->userService->getUsernameForUserId($p->getCreatedBy()),
            $p->getDescription(),
            $this->ratingsService->getAmountOfRatings($p->getId()),
            $this->ratingsService->getAverageRating($p->getId())
        );
        return $res;
    }
}