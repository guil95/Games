<?php

namespace App\Infra\Requesters;

class Requester
{
    protected $url;

    public static function getResult(string $url): array
    {
        return json_decode(file_get_contents($url), true);
    }

}
