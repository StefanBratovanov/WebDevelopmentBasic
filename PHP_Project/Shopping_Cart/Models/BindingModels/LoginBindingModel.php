<?php

namespace Models\BindingModels;

class LoginBindingModel
{
    private $username;
    private $password;

    function __construct(array $parameters)
    {
        $this->setUsername($parameters['username']);
        $this->setPassword($parameters['password']);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = crypt($password, PASSWORD_DEFAULT);
    }


}