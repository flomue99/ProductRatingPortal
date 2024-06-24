<?php

namespace Application\Entities;

class Product
{
    public function __construct(
        private int    $id,
        private string $name,
        private string $manufacturer,
        private string $description,
        private int $createdBy)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
}