<?php

namespace App\Games;

class DuplaSena extends Game{

    public function __construct()
    {
        $this->name = 'Dupla Sena';
        $this->url = Constants::DUPLA_SENA_URL;
    }
}