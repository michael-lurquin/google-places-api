<?php

namespace MichaelLurquin\GooglePlaces\Tests;

use MichaelLurquin\GooglePlaces\GooglePlacesFacade;
use MichaelLurquin\GooglePlaces\GooglePlacesServiceProvider;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class GooglePlacesTest extends OrchestraTestCase
{
    /**
     * Load package service provider
     */
    protected function getPackageProviders($app)
    {
        return [GooglePlacesServiceProvider::class];
    }

    /**
     * Load package alias
     */
    protected function getPackageAliases($app)
    {
        return ['GooglePlaces' => GooglePlacesFacade::class];
    }

    public function testSomethingIsTrue()
    {
        $this->assertTrue(TRUE);
    }
}