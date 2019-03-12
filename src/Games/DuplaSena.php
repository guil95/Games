<?php
/**
 * Created by PhpStorm.
 * User: grodrigues
 * Date: 06/03/19
 * Time: 17:59
 */

namespace App\Games;

class DuplaSena extends Game{

    public function __construct()
    {
        $this->name = 'Dupla Sena';
        $this->url = Constants::DUPLA_SENA_URL;
    }
}