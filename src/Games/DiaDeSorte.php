<?php
/**
 * Created by PhpStorm.
 * User: grodrigues
 * Date: 06/03/19
 * Time: 17:59
 */

namespace App\Games;

class DiaDeSorte extends Game{

    public function __construct()
    {
        $this->name = 'Dia de Sorte';
        $this->url = Constants::DIA_DE_SORTE_URL;
    }
}