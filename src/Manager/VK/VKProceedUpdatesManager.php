<?php

namespace App\Manager\VK;

use App\Entity\VKAccount;
use App\ProviderFacade\VK\VKProviderFacade;
use App\Repository\VKAccountRepository;
use DateTimeImmutable;
use Throwable;

class VKProceedUpdatesManager
{
    private VKAccountRepository $accountRepository;
    private VKProviderFacade $providerFacade;

    public function __construct(VKAccountRepository $accountRepository, VKProviderFacade $providerFacade)
    {
        $this->accountRepository = $accountRepository;
        $this->providerFacade = $providerFacade;
    }

    public function proceedUpdates(): void
    {
        $accounts = $this->accountRepository->findLoggedIn();

        foreach ($accounts as $account) {
            $this->proceedAccount($account);
        }

        $this->accountRepository->flush();
    }

    private function proceedAccount(VKAccount $account): void
    {
        try {
            $now = new DateTimeImmutable();
            $this->providerFacade->proceedUpdates($account);
            $account->setLastSuccessfulProceed($now);
        } catch (Throwable $throwable) {
            dump($throwable);
            echo $throwable->getMessage();
        }
    }
}