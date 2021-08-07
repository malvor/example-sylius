<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Sylius\Component\Core\Model\AdjustmentInterface as BaseAdjustmentInterface;

interface AdjustmentInterface extends BaseAdjustmentInterface
{
    public const ORDER_ITEM_ADDITIONAL_OPTION = 'product_additional_option';
}
