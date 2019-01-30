<?php
namespace App\Machine;

/**
 * Class PurchasedItem
 * @package App\Machine
 */
class PurchasedItem implements PurchasedItemInterface
{
	
	/**
     * @var int
     */
    private $itemQuantity;
	
	/**
     * @var float
     */
    private $itemPrice;
	
	/**
     * @var float
     */
    private $paidAmount;
	
	/**
     * @var array
     */
    private $coins = [
		0.01,
		0.02,
		0.05,
		0.1,
		0.2,
		0.5,
		1,
		2,
	];
	
	/**
     * @param int $itemQuantity
     * @param float $itemPrice
     *
     */
	public function __construct(int $itemQuantity, float $itemPrice, float $paidAmount, array $coins)
    {
        $this->itemQuantity = $itemQuantity;
		$this->itemPrice = $itemPrice;
		$this->paidAmount = $paidAmount;
		$this->coins = $coins;
    }
	
	/**
     * @return integer
     */
    public function getItemQuantity() {
		
		if ($this->getTotalAmount() > $this->paidAmount) {
			
			// Throw error
			throw new \Exception('Error: You need <info>'. $this->getTotalAmount() . '€</info> to buy <info>' . $this->itemQuantity . '</info> packs.', 1);
			
			// Set a valid item quantity for paid amount instead of error
			$this->itemQuantity = (int) ($this->paidAmount / $this->itemPrice);
		}
		
		return $this->itemQuantity;
	
	}
	
	/**
     * @return float
     */
    public function getItemPrice() {
		return round($this->itemPrice, 2);
	}
	
	/**
     * @return float
     */
    public function getTotalAmount() {
		return round($this->itemQuantity * $this->itemPrice, 2);
	}
	
	/**
     * @return float
     */
    public function getPaidAmount() {
		return round($this->paidAmount, 2);
	}
	
	/**
     * @return float
     */
    public function getChangeValue() {
		return round($this->getPaidAmount() - $this->getTotalAmount(), 2);
	}
	
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
    public function getChange() {
	
		$changeValue = $this->getChangeValue();
		$change = [];
		
		// Get coins and sort
		$coins = $this->coins;
		rsort($coins);
		
		if ($changeValue > 0) {
			foreach ($coins as $value):
				$value = round($value, 2);
			
				if ($value <= $changeValue) {
					$count = (int) ($changeValue / $value);
					
					$change[] = [number_format($value, 2), $count];
					$changeValue = round($changeValue - $count * $value, 2);
				}
			endforeach;
		}
		
		return $change;
	}
	
}