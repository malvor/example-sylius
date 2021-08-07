<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Sylius\Component\Core\Model\ProductInterface;

interface ProductAdditionalOptionInterface
{
    public function setName(?string $name): void;
    public function getName(): ?string;
    public function getPrice(): ?int;
    public function setPrice(?int $price): void;
    public function setProduct(?ProductInterface $product): void;
    public function getProduct(): ?ProductInterface;
}
