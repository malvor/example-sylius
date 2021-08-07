<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements ProductInterface
{
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductAdditionalOption", mappedBy="product", cascade={"persist", "remove", "merge"})
     */
    private $additionalOptions;

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }

    public function getAdditionalOptions(): Collection
    {
        return $this->additionalOptions;
    }

    public function addAdditionalOption(ProductAdditionalOption $additionalOption): void
    {
        $additionalOption->setProduct($this);
        $this->additionalOptions->add($additionalOption);
    }

    public function removeAdditionalOption(ProductAdditionalOption $additionalOption): void
    {
        $additionalOption->setProduct(null);
        $this->additionalOptions->removeElement($additionalOption);
    }
}
