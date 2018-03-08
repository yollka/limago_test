<?php

namespace App\Machine;

/**
 * Interface PurchasedItemInterface.
 */
interface PurchasedItemInterface
{
    /**
     * @return int
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getTotalAmount();

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange();
}
