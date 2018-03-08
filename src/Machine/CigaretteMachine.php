<?php

namespace App\Machine;

/**
 * {@inheritdoc}
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * {@inheritdoc}
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        if (!$this->isAmountEnough($purchaseTransaction)) {
            return $this->createPurchasedItem(0, $purchaseTransaction->getPaidAmount());
        }

        return $this->createPurchasedItem($purchaseTransaction->getItemQuantity(), $purchaseTransaction->getPaidAmount());
    }

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return bool
     */
    private function isAmountEnough(PurchaseTransactionInterface $purchaseTransaction)
    {
        return self::ITEM_PRICE * $purchaseTransaction->getItemQuantity() <= $purchaseTransaction->getPaidAmount();
    }

    /**
     * @param int $itemQuantity
     * @param float $paidAmount
     * @return PurchasedItem
     */
    private function createPurchasedItem(int $itemQuantity, float $paidAmount)
    {
        return new PurchasedItem($itemQuantity, self::ITEM_PRICE, $paidAmount);
    }
}
