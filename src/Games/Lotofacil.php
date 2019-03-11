<?php

namespace App\Games;

class Lotofacil extends Game{

    public function __construct()
    {
        $this->name = 'Lotofacil';
        $this->url = Constants::LOTOFACIL_URL;
    }
}