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
    /**
     * @var Game
     */
    private $game;

    public function __construct()
    {
        $this->games = [
            Constants::MEGA_SENA => new MegaSena(),
            Constants::QUINA => new Quina(),
            Constants::LOTOFACIL => new Lotofacil(),
            Constants::LOTOMANIA => new Lotomania(),
            Constants::TIMEMANIA => new Timemania(),
            Constants::DIA_DE_SORTE => new DiaDeSorte(),
            Constants::DUPLA_SENA => new DuplaSena(),
        ];
    }

    public function __invoke()
    {
        $this->printOptions();
        $this->setGame();
        $this->setResult();
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

    private function setGame()
    {
        do {
            echo "\nSelect the game:\n";
            $game = trim(fgets(STDIN));
            $this->game = $this->games[$game];
        } while(
            !in_array(
                $game,
                array_keys($this->games)
            )
        );
    }

    private function setResult()
    {
        $this->result = Requester::getResult(
            $this->game->getUrl()
        );
    }

    private function showResultGame()
    {
        echo PHP_EOL.'Jogo: '. $this->game->getName();
        echo PHP_EOL.'Data: '.$this->getDate();
        echo PHP_EOL.'Números Sorteados: '.$this->getNumbers();
        echo PHP_EOL.'Quantidade de ganhadores: '.$this->getWinners().PHP_EOL;
    }

    private function getNumbers(): string
    {
        if(is_array($this->result['sorteio'][0])){
            return $this->treateResultArray();
        }

        return $this->treateResult();
    }

    private function treateResultArray(): string
    {
        $result = '';
        for($i = 0; $i < count($this->result['sorteio']); $i++){
            foreach ($this->result['sorteio'][$i] as &$number){
                $number = str_pad($number, 2, "0", STR_PAD_LEFT);
            }
            $result .= ($i +1).'º Sorteio :'.join(', ', $this->result['sorteio'][$i]).PHP_EOL;
        }
        return PHP_EOL.$result;
    }

    private function treateResult(): string
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

    private function getWinners(): string
    {
        if(is_array($this->result['ganhadores'][0])){
            return $this->getWinnersArray();
        }
        return $this->result['ganhadores'][0];
    }

    private function getWinnersArray(): string
    {
        $winners = '';
        for($i = 0; $i < count($this->result['ganhadores']); $i++){
            $winners .= ($i +1).'º Sorteio: '. $this->result['ganhadores'][$i][0].PHP_EOL;
        }

        return PHP_EOL.$winners;
    }
}