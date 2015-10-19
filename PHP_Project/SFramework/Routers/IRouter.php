<?php

namespace SF\Routers;


interface IRouter
{
    public function getUri();

    public function getPost();
}