<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\Common\Collections\Collection;

interface ProductInterface
{
    public function getAdditionalOptions(): Collection;
    public function addAdditionalOption(ProductAdditionalOption $additionalOption): void;
    public function removeAdditionalOption(ProductAdditionalOption $additionalOption): void;
}
