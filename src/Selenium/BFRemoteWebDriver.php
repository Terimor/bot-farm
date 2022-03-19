<?php

namespace App\Selenium;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;

class BFRemoteWebDriver extends RemoteWebDriver
{
    public function findElementOrNull(WebDriverBy $by): ?RemoteWebElement
    {
        try {
            return $this->findElement($by);
        } catch (NoSuchElementException) {
            return null;
        }
    }

    public function __destruct()
    {
        $this->quit();
    }
}