<?php
namespace App\Entity;

class Product
{
    public function __construct(
        private int $id,
        private string $name,
        private float $price,
        private int $stock,
        private bool $isNew = false,
        private int $discount = 0,
        private string $image = "",
        private string $description = ""
    ) {}

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function isNew(): bool { return $this->isNew; }
    public function getDiscount(): int { return $this->discount; }
    public function getImage(): string { return $this->image; }
    public function getDescription(): string { return $this->description; }

    public function getTotalValue(): float
    {
        return $this->price * $this->stock;
    }
}
