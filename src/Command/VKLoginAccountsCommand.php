<?php

namespace App\Command;

use App\Manager\VK\VKLoginAccountsManager;
use App\Manager\VK\VKProceedUpdatesManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'vk:login-accounts',
    description: 'Command to login accounts | VK',
)]
class VKLoginAccountsCommand extends Command
{
    private VKLoginAccountsManager $loginAccountsManager;

    public function __construct(VKLoginAccountsManager $loginAccountsManager)
    {
        $this->loginAccountsManager = $loginAccountsManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->loginAccountsManager->loginUnauthorized();
        $io->success('Command execution complete');

        return Command::SUCCESS;
    }
}
