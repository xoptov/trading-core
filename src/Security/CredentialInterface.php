<?php

namespace Xoptov\TradingCore\Security;

interface CredentialInterface
{
	/**
	 * @param string $body
	 * @return string
	 */
    public function getSignature($body);
}