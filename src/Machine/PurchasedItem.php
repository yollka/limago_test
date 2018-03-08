<?php

namespace App\Machine;

/**
 * {@inheritdoc}
 */
class PurchasedItem implements PurchasedItemInterface
{
    const ONE_CENT = 0.01;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $itemPrice;

    /**
     * @var float
     */
    private $purchasedAmount;

    /**
     * @param int $quantity
     * @param float $itemPrice
     * @param float $purchasedAmount
     */
    public function __construct(int $quantity, float $itemPrice, float $purchasedAmount)
    {
        $this->quantity = $quantity;
        $this->itemPrice = $itemPrice;
        $this->purchasedAmount = $purchasedAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function getItemQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalAmount()
    {
        return $this->quantity * $this->itemPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getChange()
    {
        $change = $this->purchasedAmount - $this->getTotalAmount();

        return [
            $this->getCalculatedChange($change, self::ONE_CENT),
        ];
    }

    /**
     * @param float $change
     * @param float $coin
     * @return array
     */
    private function getCalculatedChange(float $change, float $coin)
    {
        return [$coin, $change / $coin];
    }
}
