<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
	
	/**
     * @var int
     */
    private $packsAvailable;
	
	/**
     * @var int
     */
    private $maximumChange;
	
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
     * @param int $packsAvailable
     * @param float $maximumChange
     *
     */
	public function __construct(int $packsAvailable, int $maximumChange)
    {
        $this->packsAvailable = $packsAvailable;
		$this->maximumChange = $maximumChange;
    }
	
	/**
     * Executes the purchase transaction
     *
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return array
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
		if ($purchaseTransaction->getItemQuantity() > $this->packsAvailable) {
			throw new \Exception('Error: You can buy a maximum of <info>'. $this->packsAvailable . '</info> packs.', 1);
		} else {

			if ($purchaseTransaction->getChangeValue() > $this->maximumChange) {
				throw new \Exception('Error: We can give change for a max value of <info>'. $this->maximumChange . '</info> €.', 1);
			}
			
			return $purchaseTransaction->process();
		}
    }
	
	/**
     * @return array
     */
    public function getCoins() {
		
		return $this->coins;
	
	}
}