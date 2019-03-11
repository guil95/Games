<?php

namespace App\Games;

class Quina extends Game{

    public function __construct()
    {
        $this->name = 'Quina';
        $this->url = Constants::QUINA_URL;
    }
}