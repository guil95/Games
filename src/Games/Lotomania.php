<?php

namespace App\Games;

class Lotomania extends Game{

    public function __construct()
    {
        $this->name = 'Lotomania';
        $this->url = Constants::LOTOMANIA_URL;
    }
}