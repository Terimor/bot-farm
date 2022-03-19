<?php

namespace App\ProviderFacade\VK;

use App\Entity\VKAccount;
use App\Module\TextGenerator\TextGeneratorService;
use App\ProviderFacade\VK\Decorator\VKApiClientDecorator;
use App\ProviderFacade\VK\Service\VKLoginService;
use DateTimeImmutable;
use VK\Client\VKApiClient;

class VKProviderFacade
{
    private VKLoginService $loginService;
    private TextGeneratorService $textGeneratorService;

    public function __construct(VKLoginService $loginService, TextGeneratorService $textGeneratorService)
    {
        $this->loginService = $loginService;
        $this->textGeneratorService = $textGeneratorService;
    }

    public function login(VKAccount $account): string
    {
        return $this->loginService->login($account);
    }

    public function proceedUpdates(VKAccount $account): void
    {
        $client = new VKApiClientDecorator($account->getAccessToken());

        foreach ($client->getGroupIds() as $groupId) {
            foreach ($client->getWallForGroup($groupId) as $post) {
                $createdDateTime = new DateTimeImmutable("@{$post['date']}");

                if ($createdDateTime < $account->getLastSuccessfulProceed()) {
                    break;
                }

                $comment = $this->textGeneratorService->generateText($account);

                $client->sendComment($post['id'], $post['owner_id'], $comment);
                sleep(1);
                echo 'comment posted';
            }
        }
    }
}