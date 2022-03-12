<?php

namespace App\Command;

use App\Manager\VK\VKProceedUpdatesManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'vk:proceed-updates',
    description: 'Command to track updates and react them | VK',
)]
class VKProceedUpdatesCommand extends Command
{
    private VKProceedUpdatesManager $proceedUpdatesManager;

    public function __construct(VKProceedUpdatesManager $trackUpdatesManager)
    {
        $this->proceedUpdatesManager = $trackUpdatesManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->proceedUpdatesManager->proceedUpdates();
        $io->success('Command execution complete');

        return Command::SUCCESS;
    }
}
