<?php
namespace App\Machine;

/**
 * Interface PurchasedItemInterface
 * @package App\Machine
 */
interface PurchasedItemInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity();
	
	/**
     * @return float
     */
    public function getItemPrice();
	
    /**
     * @return float
     */
    public function getTotalAmount();
	
	/**
     * @return float
     */
	public function getPaidAmount();
	
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