<?php

namespace App\Infra\Requesters;

class Requester
{
    protected $url;

    public function getResult(string $url): array
    {
        $result = file_get_contents($url);
        return json_decode($result, true);
    }

}