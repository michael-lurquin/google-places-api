<?php

namespace MichaelLurquin\GooglePlaces;

use Illuminate\Config\Repository as Config;

class GooglePlaces
{
    public function __construct(Config $config)
    {
        dd($config);
    }
}