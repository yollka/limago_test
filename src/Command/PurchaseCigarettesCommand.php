<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->addArgument('packs', InputArgument::REQUIRED, 'How many packs do you want to buy?');
        $this->addArgument('amount', InputArgument::REQUIRED, 'The amount in euro.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount = (float)\str_replace(',', '.', $input->getArgument('amount'));

        $cigaretteMachine = new CigaretteMachine();
        $purchasedItem = $cigaretteMachine->execute(new PurchaseTransaction($itemCount, $amount));

        if ($purchasedItem->getItemQuantity() > 0) {
            $output->writeln(
                sprintf(
                    'You bought <info>%d</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>.',
                    $purchasedItem->getItemQuantity(),
                    $this->formatNumber($purchasedItem->getTotalAmount()),
                    $this->formatNumber($purchasedItem->getTotalAmount() / $purchasedItem->getItemQuantity())
                )
            );

            $output->writeln('Your change is:');

            $table = new Table($output);
            $table
                ->setHeaders(['Coins', 'Count'])
                ->setRows($purchasedItem->getChange())
            ;
            $table->render();
        } else {
            $output->writeln(
                sprintf('You can\'t buy <info>%d</info> packs of cigarettes.', $itemCount)
            );
        }
    }

    /**
     * @param float $number
     * @return string
     */
    private function formatNumber(float $number)
    {
        return number_format($number, 2);
    }
}
