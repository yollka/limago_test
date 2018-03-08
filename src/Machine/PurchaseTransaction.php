<?php

namespace App\Machine;

/**
 * {@inheritdoc}
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $amount;

    /**
     * @param int $quantity
     * @param float $amount
     */
    public function __construct(int $quantity, float $amount)
    {
        $this->quantity = $quantity;
        $this->amount = $amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return {@inheritdoc}
     */
    public function getPaidAmount()
    {
        return $this->amount;
    }
}
