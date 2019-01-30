<?php
namespace App\Machine;

use App\Machine\PurchasedItem;
	
/**
 * Class PurchaseTransaction
 * @package App\Machine
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
	
	/**
     * @instance PurchasedItem
     */
    private $purchasedItem;
	
	/**
     * @param int $quantity
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
	public function __construct(PurchasedItem $purchasedItem)
    {
        $this->purchasedItem = $purchasedItem;
    }
	
	/**
     * @return integer
     */
    public function getItemQuantity() {
		return $this->purchasedItem->getItemQuantity();
	}
	
	/**
     * @return float
     */
	public function getPaidAmount() {
		return $this->purchasedItem->getPaidAmount();
	}
	
	/**
     * @return float
     */
	public function getTotalAmount() {
		return $this->purchasedItem->getTotalAmount();
	}
	
	/**
     * @return float
     */
	public function getItemPrice() {
		return $this->purchasedItem->getItemPrice();
	}
	
	/**
     * @return array
     */
	public function getChange() {
		return $this->purchasedItem->getChange();
	}
	
	/**
     * @return float
     */
	public function getChangeValue() {
		return $this->purchasedItem->getChangeValue();
	}
	
	public function process() {
		if ($this->getItemQuantity() > 0) {
			
			return [
				'quantity' => $this->getItemQuantity(), 
				'total_amount' => $this->getTotalAmount(), 
				'item_price' => $this->getItemPrice(),
				'change_value' => $this->getChangeValue(), 
				'change' => $this->getChange()
			];
			
		} else {
			throw new \Exception('Error: You should select at least <info>1</info> pack.', 1);
		}
	}
}