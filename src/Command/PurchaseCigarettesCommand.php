<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use App\Machine\PurchasedItem;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));
		
		// Init cigarette machine
       	$cigaretteMachine = new CigaretteMachine($stock = 10, $change = 20);
     	
		// try to create a purchased item
		$purchasedItem = new PurchasedItem($itemCount, $cigaretteMachine::ITEM_PRICE, $amount, $cigaretteMachine->getCoins());

		// Create a transaction based on a valid item
		$purchaseTransaction = new PurchaseTransaction($purchasedItem);
		
		try {
			
			// Execute transaction
			$response = $cigaretteMachine->execute($purchaseTransaction);
			
			if ($response['quantity'] == 1) {
				$output->writeln('You bought <info>'. $response['quantity'] .'</info> pack of cigarettes for <info>-'. number_format($response['total_amount'], 2) .'€</info>');
			} else {
				$output->writeln('You bought <info>'. $response['quantity'] .'</info> packs of cigarettes for <info>-'. number_format($response['total_amount'], 2) .'€</info>, each for <info>-'.number_format($response['item_price'], 2).'€</info>. ');
			}
				
			$output->writeln('Your change is: <info>' . number_format($response['change_value'], 2) .'€</info>');

			$table = new Table($output);
			$table
				->setHeaders(array('Coins', 'Count'))
				->setRows($response['change'])
			;
			$table->render();

		} catch (\Exception $e) {
			$output->writeln($e->getMessage());
		}

    }
}