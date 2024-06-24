<?php

namespace Application;

class UpdateProductCommand
{
    const ERROR_NAME_REQUIRED = 0x01;
    const ERROR_MANUFACTURER_REQUIRED = 0x02;
    const ERROR_USER_NOT_AUTHENTICATED = 0x04;

    public function __construct(
        private Interfaces\ProductRepository   $productRepository,
        private Services\AuthenticationService $authenticationService
    )
    {
    }

    public function execute(int $id, string $name, string $manufacturer, string $description): int
    {
        $errors = 0;
        //check if current user is authenticated
        $userId = $this->authenticationService->getUserId();
        if ($userId === null) {
            $errors |= self::ERROR_USER_NOT_AUTHENTICATED;
        }

        //check if name is empty
        if ($name === '') {
            $errors |= self::ERROR_NAME_REQUIRED;
        }

        //check if manufacturer is empty
        if ($manufacturer === '') {
            $errors |= self::ERROR_MANUFACTURER_REQUIRED;
        }

        if ($errors !== 0) {
            return $errors;
        }

        $this->productRepository->updateProduct($id, $userId, $name, $manufacturer, $description);
        return 0;
    }
}