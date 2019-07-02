<?php

namespace App\CLI;


final class GamesCLI
{
    public static function inputMessage(string $title)
    {
        echo "\n$title\n";
        return strtoupper(trim(fgets(STDIN)));
    }
}