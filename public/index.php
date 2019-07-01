<?php
declare(strict_types=1);
require_once '../vendor/autoload.php';

use App\Lottery;

(new Lottery(
    new \App\Games\MegaSena(),
    new \App\Games\Quina(),
    new \App\Games\Lotofacil(),
    new \App\Games\Lotomania(),
    new \App\Games\Timemania(),
    new \App\Games\DiaDeSorte(),
    new \App\Games\DuplaSena()
))();