<?php

namespace App\Games;

class MegaSena extends Game{

    public function __construct()
    {
        $this->name = 'Mega Sena';
        $this->url = Constants::MEGA_SENA_URL;
    }
}