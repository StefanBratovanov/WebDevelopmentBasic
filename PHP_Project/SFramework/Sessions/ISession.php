<?php

namespace SF\Sessions;


interface ISession
{
    public function getSessionId();

    public function saveSession();

    public function destroySession();

    public function unsetSessionProperty($key);

    public function __get($name);

    public function __set($name, $value);
}