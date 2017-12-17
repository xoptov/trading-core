<?php

namespace Xoptov\TradingCore\Security;

interface CredentialInterface
{
    /**
     * @return string
     */
    public function getLogin();

    /**
     * @return string
     */
    public function getPassword();
}