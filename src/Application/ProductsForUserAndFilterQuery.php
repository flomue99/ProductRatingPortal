<?php

namespace Application;

use Application\DAO\ProductData;

class ProductsForUserAndFilterQuery
{
    public function __construct(
        private Interfaces\ProductRepository   $productRepository,
        private Services\RatingsService        $ratingsService,
        private Services\AuthenticationService $authenticationService,
        private Services\UserService           $userService)
    {
    }

    public function execute($searchString): array //of ProductData
    {
        $userId = $this->authenticationService->getUserId();
        $res = [];
        foreach ($this->productRepository->getAllProductsForUserAndFilter($userId, $searchString) as $p) {
            $res[] = new ProductData(
                $p->getId(),
                $p->getName(),
                $p->getManufacturer(),
                $p->getCreatedBy(),
                $this->userService->getUsernameForUserId($p->getCreatedBy()),
                $p->getDescription(),
                $this->ratingsService->getAmountOfRatings($p->getId()),
                $this->ratingsService->getAverageRating($p->getId())
            );
        }
        return $res;
    }
}