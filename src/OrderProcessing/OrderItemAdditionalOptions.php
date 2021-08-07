<?php

declare(strict_types=1);

namespace App\OrderProcessing;

use App\Entity\Order\AdjustmentInterface;
use App\Entity\Product\ProductAdditionalOptionInterface;
use App\Entity\Product\ProductInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class OrderItemAdditionalOptions implements OrderProcessorInterface
{
    /**
     * @var AdjustmentFactoryInterface
     */
    private $adjustmentFactory;

    public function __construct(AdjustmentFactoryInterface $adjustmentFactory)
    {
        $this->adjustmentFactory = $adjustmentFactory;
    }

    public function process(OrderInterface $order): void
    {
        /** @var OrderItemInterface $item */
        foreach ($order->getItems() as $item) {
            /** @var ProductInterface $product */
            $product = $item->getProduct();

            $this->updateItem($item, $product->getAdditionalOptions());
        }
    }

    private function updateItem(OrderItemInterface $item, Collection $additionalOptions): void
    {
        /** @var ProductAdditionalOptionInterface $additionalOption */
        foreach ($additionalOptions as $additionalOption) {
            $item->addAdjustment($this->adjustmentFactory->createWithData(
                AdjustmentInterface::ORDER_ITEM_ADDITIONAL_OPTION, $additionalOption->getName(), $additionalOption->getPrice()
            ));
        }
    }
}
