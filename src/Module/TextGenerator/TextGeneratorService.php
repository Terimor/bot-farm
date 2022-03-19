<?php

namespace App\Module\TextGenerator;

use App\Entity\VKAccount;

class TextGeneratorService
{
    public function generateText(VKAccount $account): string
    {
        return $account->getMessageText();
    }
}