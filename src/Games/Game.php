<?php

namespace App\Games;

abstract class Game{
    protected $name;
    protected $url;

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }
}