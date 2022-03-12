<?php

namespace App\ProviderFacade\VK;

use App\Entity\VKAccount;
use App\ProviderFacade\VK\Service\VKLoginService;

class VKProviderFacade
{
    private VKLoginService $loginService;

    public function __construct(VKLoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(VKAccount $account): string
    {
        return $this->loginService->login($account);
    }
}