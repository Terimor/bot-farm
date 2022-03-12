<?php

namespace App\Manager\VK;

use App\Entity\VKAccount;
use App\ProviderFacade\VK\VKProviderFacade;
use App\Repository\VKAccountRepository;
use Throwable;

class VKLoginAccountsManager
{
    private VKAccountRepository $accountRepository;
    private VKProviderFacade $providerFacade;

    public function __construct(VKAccountRepository $accountRepository, VKProviderFacade $providerFacade)
    {
        $this->accountRepository = $accountRepository;
        $this->providerFacade =  $providerFacade;
    }

    public function loginUnauthorized(): void
    {
        $accountsToLogIn = $this->accountRepository->findNotLoggedIn();

        foreach ($accountsToLogIn as $account) {
            $this->loginAccount($account);
        }

        $this->accountRepository->flush();
    }

    private function loginAccount(VKAccount $account): void
    {
        try {
            $accessToken = $this->providerFacade->login($account);
            $account->setAccessToken($accessToken);
        } catch (Throwable $throwable) {
            echo $throwable->getMessage();
        }
    }
}