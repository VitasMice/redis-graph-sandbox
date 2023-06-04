<?php

declare(strict_types=1);

namespace App\Command;

use App\Storage\ItemStorage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupRedisCommand extends Command
{
    public function __construct(private ItemStorage $itemStorage)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('redis:setup');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->itemStorage->create();

        $this->itemStorage->getInventory();

        $this->itemStorage->removeGraph();

        return Command::SUCCESS;
    }
}
