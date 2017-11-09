<?php

namespace MichaelLurquin\GooglePlaces\Facades;

use Illuminate\Support\Facades\Facade;

class GooglePlaces extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MichaelLurquin\GooglePlaces\GooglePlaces::class;
    }
}