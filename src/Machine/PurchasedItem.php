<?php

namespace App\Machine;

/**
 * {@inheritdoc}
 */
class PurchasedItem implements PurchasedItemInterface
{
    /**
     * @var float[]
     */
    private $availableChange = [
        'one_euro' => 1.00,
        'fifty_cent' => 0.50,
        'twenty_cent' => 0.10,
        'ten_cent' => 0.10,
        'five_cent' => 0.05,
        'two_cent ' => 0.02,
        'one_cent' => 0.01,
    ];

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

        $result = [];

        while ($this->compare($change, 0) > 0) {

            $nominal = $this->getAvailableNominal($change);

            $cnt = $this->getPossibleCountByNominal($nominal, $change);

            $result[] = [$nominal, $cnt];

            $change -= $cnt * $nominal;
        }

        return $result;
    }

    /**
     * @param float $change
     * @return float
     */
    private function getAvailableNominal(float $change)
    {
        foreach ($this->availableChange as $value) {
            if ($this->compare($value, $change) <= 0) {
                return $value;
            }
        }
    }

    /**
     * @param float $nominal
     * @param float $change
     * @return int
     */
    private function getPossibleCountByNominal(float $nominal, float $change)
    {
        $cnt = 0;

        while ($this->compare($change - $nominal, 0) >= 0) {
            $cnt++;
            $change -= $nominal;
        }

        return $cnt;
    }

    /**
     * @param float $left
     * @param float $right
     * @return int
     */
    private function compare(float $left, float $right)
    {
        return bccomp($left, $right, 2);
    }
}
