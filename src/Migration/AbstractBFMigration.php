<?php

namespace App\Migration;

use Doctrine\Migrations\AbstractMigration;

abstract class AbstractBFMigration extends AbstractMigration
{
    protected function insertVKAccountV0(string $username, string $password, int $providerId): void
    {
        $this->addSql(
            'INSERT INTO VKAccount SET username = :username, password = :password, providerId = :providerId',
            [
                'username' => $username,
                'password' => $password,
                'providerId' => $providerId,
            ]
        );
    }

    protected function insertVKAccountV1(string $username, string $password, string $messageText): void
    {
        $this->addSql(
            'INSERT INTO VKAccount SET username = :username, password = :password, messageText = :messageText',
            [
                'username' => $username,
                'password' => $password,
                'messageText' => $messageText,
            ]
        );
    }
}