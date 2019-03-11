<?php

namespace App\Games;

class Timemania extends Game{

    public function __construct()
    {
        $this->name = 'Timemania';
        $this->url = Constants::TIMEMANIA_URL;
    }
}