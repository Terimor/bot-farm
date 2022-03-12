<?php

namespace App\Factory;

use App\Selenium\BFRemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class WebDriverFactory
{
    private const CHROMEDRIVER_URI = 'http://chromedriver:4444';

    public function createChrome(bool $headless): BFRemoteWebDriver
    {
        $chromeOptions = new ChromeOptions();
        if ($headless) {
            $chromeOptions->addArguments(['-headless']);
        }
        $desiredCapabilities = DesiredCapabilities::chrome();
        $desiredCapabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);

        return BFRemoteWebDriver::create(self::CHROMEDRIVER_URI, $desiredCapabilities);
    }
}