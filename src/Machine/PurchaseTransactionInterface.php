<?php

namespace App\Machine;

/**
 * Interface PurchasableItemInterface.
 */
interface PurchaseTransactionInterface
{
    /**
     * @return int
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getPaidAmount();
}
