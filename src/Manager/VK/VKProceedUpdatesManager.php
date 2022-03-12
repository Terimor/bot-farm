<?php

namespace App\Manager\VK;

use App\Repository\VKAccountRepository;

class VKProceedUpdatesManager
{
    private VKAccountRepository $accountRepository;

    public function __construct(VKAccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function proceedUpdates(): void
    {
        $accounts = $this->accountRepository->findLoggedIn();

        foreach ($accounts as $account) {

        }
    }
}