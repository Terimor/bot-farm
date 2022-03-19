<?php

namespace App\ProviderFacade\VK\Service;

use App\Entity\VKAccount;
use App\Factory\WebDriverFactory;
use Facebook\WebDriver\WebDriverBy;
use Throwable;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;

class VKLoginService
{
    private const CLIENT_ID = 8098180;
    private const REDIRECT_URI = 'https://oauth.vk.com/blank.html';
    private const STATE = 'secret_state_code';

    private WebDriverFactory $webDriverFactory;

    public function __construct(WebDriverFactory $webDriverFactory)
    {
        $this->webDriverFactory = $webDriverFactory;
    }

    public function login(VKAccount $account): string
    {
        $oauth = new VKOAuth();

        $browserUrl = $this->getLoginBrowserUrl($oauth);

        return $this->getAccessToken($account, $browserUrl);
    }

    private function getLoginBrowserUrl(VKOAuth $oauth): string
    {
        return $oauth->getAuthorizeUrl(
            response_type: VKOAuthResponseType::TOKEN,
            client_id: self::CLIENT_ID,
            redirect_uri: self::REDIRECT_URI,
            display: VKOAuthDisplay::PAGE,
            scope: [VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS],
            state: self::STATE
        );
    }

    private function getAccessToken(VKAccount $account, string $browserUrl): string
    {
        $webDriver = $this->webDriverFactory->createChrome(headless: false);

        $webDriver->get($browserUrl);
        $webDriver->findElement(WebDriverBy::cssSelector('input[name=email]'))
            ->sendKeys($account->getUsername());
        $webDriver->findElement(WebDriverBy::cssSelector('input[name=pass]'))
            ->sendKeys($account->getPassword())
            ->submit();

        $webDriver->findElementOrNull(WebDriverBy::cssSelector('button.flat_button.fl_r.button_indent'))?->click();
        $redirectedUrl = $webDriver->getCurrentURL();

        $queryString = parse_url($redirectedUrl)['fragment'];
        parse_str($queryString, $parsedQuery);

        return $parsedQuery['access_token'];
    }
}