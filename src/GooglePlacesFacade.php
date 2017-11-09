<?php

namespace MichaelLurquin\GooglePlaces;

use Illuminate\Support\Facades\Facade;

class GooglePlacesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GooglePlaces::class;
    }
}