<?php

namespace Xoptov\TradingCore\Security;

class Credential implements CredentialInterface
{
    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /**
     * Credential constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
}