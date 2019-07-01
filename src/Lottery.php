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
use http\Exception\InvalidArgumentException;

class Lottery
{
    private $games = [];
    private $result;
    /**
     * @var Game
     */
    private $game;

    /**
     * Lottery constructor.
     * @param MegaSena $megaSena
     * @param Quina $quina
     * @param Lotofacil $lotofacil
     * @param Lotomania $lotomania
     * @param Timemania $timemania
     * @param DiaDeSorte $diaDeSorte
     * @param DuplaSena $duplaSena
     */
    public function __construct(
        MegaSena $megaSena,
        Quina $quina,
        Lotofacil $lotofacil,
        Lotomania $lotomania,
        Timemania $timemania,
        DiaDeSorte $diaDeSorte,
        DuplaSena $duplaSena
    ) {
        $this->games = [
            Constants::MEGA_SENA => $megaSena,
            Constants::QUINA => $quina,
            Constants::LOTOFACIL => $lotofacil,
            Constants::LOTOMANIA => $lotomania,
            Constants::TIMEMANIA => $timemania,
            Constants::DIA_DE_SORTE => $diaDeSorte,
            Constants::DUPLA_SENA => $duplaSena,
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
            echo $key . '. ' . $game->getName() . PHP_EOL;
        }
    }

    private function setGame()
    {
        do {
            echo "\nSelect the game:\n";
            $game = trim(fgets(STDIN));
        } while (
            !in_array(
                $game,
                array_keys($this->games)
            )
        );

        $this->game = $this->games[$game];
    }

    private function setResult()
    {
        $this->result = Requester::getResult(
            $this->game->getUrl()
        );
    }

    private function showResultGame()
    {
        echo PHP_EOL . 'Jogo: ' . $this->game->getName();
        echo PHP_EOL . 'Data: ' . $this->getDate();
        echo PHP_EOL . 'Números Sorteados: ' . $this->getNumbers();
        echo PHP_EOL . 'Quantidade de ganhadores: ' . $this->getWinners();
        echo PHP_EOL . 'Estimativa próximo concurso: ' . $this->getNextValue() . PHP_EOL;
    }

    /**
     * @return string
     */
    private function getNumbers(): string
    {
        if (is_array($this->result['sorteio'][0])) {
            return $this->treatResultArray();
        }

        return $this->treatResult();
    }

    /**
     * @param int $number
     * @return string
     */
    private function formatNumber(int $number): string
    {
        return str_pad($number, 2, "0", STR_PAD_LEFT);
    }

    /**
     * @param array $numbers
     */
    private function treatListResult(array &$numbers)
    {
        foreach ($numbers as &$number) {
            $number = $this->formatNumber($number);
        }
    }

    /**
     * @return string
     */
    private function treatResultArray(): string
    {
        $result = '';

        for ($i = 0; $i < count($this->result['sorteio']); $i++) {
            $this->treatListResult($this->result['sorteio'][$i]);
            $result .= ($i + 1) . 'º Sorteio: ' . join(', ', $this->result['sorteio'][$i]) . PHP_EOL;
        }

        return PHP_EOL . $result;
    }

    /**
     * @return string
     */
    private function treatResult(): string
    {
        $this->treatListResult($this->result['sorteio']);

        return join(', ', $this->result['sorteio']);
    }

    /**
     * @return string
     */
    private function getDate(): string
    {
        return date('d/m/Y', strtotime($this->result['data']));
    }

    /**
     * @return string
     */
    private function getWinners(): string
    {
        if (is_array($this->result['ganhadores'][0])) {
            return $this->getWinnersArray();
        }

        return $this->result['ganhadores'][0];
    }

    /**
     * @return string
     */
    private function getWinnersArray(): string
    {
        $winners = '';
        for ($i = 0; $i < count($this->result['ganhadores']); $i++) {
            $winners .= ($i + 1) . 'º Sorteio: ' . $this->result['ganhadores'][$i][0] . PHP_EOL;
        }

        return PHP_EOL . $winners;
    }

    /**
     * @return string
     */
    private function getNextValue(): string
    {
        return isset($this->result['proximo_estimativa']) ? 'R$ ' . number_format($this->result['proximo_estimativa'], 2, ',', '.') : 0;
    }
}