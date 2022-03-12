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
    private const CLIENT_SECRET = 'd2jTLg34WURDBqXNjd4b';
    private const REDIRECT_URI = 'http://localhost/vk';
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
        $code = $this->getCodeFromBrowserLogin($account, $browserUrl);

        return $this->getAccessToken($oauth, $code);
    }

    private function getLoginBrowserUrl(VKOAuth $oauth): string
    {
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS);

        return $oauth->getAuthorizeUrl(
            VKOAuthResponseType::CODE,
            self::CLIENT_ID,
            self::REDIRECT_URI,
            VKOAuthDisplay::PAGE,
            $scope,
            self::STATE
        );
    }

    private function getCodeFromBrowserLogin(VKAccount $account, string $browserUrl): string
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

        $queryString = parse_url($redirectedUrl)['query'];
        parse_str($queryString, $parsedQuery);

        return $parsedQuery['code'];
    }

    private function getAccessToken(VKOAuth $oauth, string $code): string
    {
        $response = $oauth->getAccessToken(self::CLIENT_ID, self::CLIENT_SECRET, self::REDIRECT_URI, $code);

        return $response['access_token'];
    }
}