<?php

namespace App;

use App\Games\Constants;
use App\Games\DiaDeSorte;
use App\Games\DuplaSena;
use App\Games\Game;
use App\Games\Lotofacil;
use App\Games\Lotomania;
use App\Games\MegaSena;
use App\Games\Quina;
use App\Games\Timemania;
use App\Infra\Requesters\Requester;

class Lottery{
    private $games = [];
    private $result;

    public function __construct()
    {
        $this->games = [
            Constants::MEGA_SENA => new MegaSena(),
            Constants::QUINA => new Quina(),
            Constants::LOTOFACIL => new Lotofacil(),
            Constants::LOTOMANIA => new Lotomania(),
            Constants::TIMEMANIA => new Timemania(),
            Constants::DIA_DE_SORTE => new DiaDeSorte(),
        ];
    }

    public function __invoke()
    {
        $this->printOptions();
        $this->setResult($this->selectGame());
        $this->showResultGame();
    }


    private function printOptions()
    {
        /**
         * $game Game
         */
        foreach ($this->games as $key => $game) {
            echo $key.'. '.$game->getName(). PHP_EOL;
        }
    }

    private function selectGame(): Game
    {
        do {
            echo "\nSelect the game:\n";
            $game = trim(fgets(STDIN));
        } while(
            !in_array(
                $game,
                array_keys($this->games)
            )
        );

        return $this->games[$game];
    }

    private function setResult(Game $game)
    {
        $this->result = Requester::getResult($game->getUrl());
    }

    private function showResultGame()
    {
        echo 'Números Sorteados: '.$this->getNumbers().PHP_EOL;
        echo 'Data: '.$this->getDate().PHP_EOL;
        echo 'Quantidade de ganhadores: '. $this->getWinners(). PHP_EOL;
    }

    private function getNumbers()
    {

        foreach ($this->result['sorteio'] as &$number){
            $number = str_pad($number, 2, "0", STR_PAD_LEFT);
        }

        return join(', ', $this->result['sorteio']);
    }

    private function getDate(): string
    {
        return date('d/m/Y', strtotime($this->result['data']));
    }

    private function getWinners()
    {
        return $this->result['ganhadores'][0];
    }
}