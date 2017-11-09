<?php

namespace MichaelLurquin\GooglePlaces\Tests;

use MichaelLurquin\GooglePlaces\Facades\GooglePlaces;
use MichaelLurquin\GooglePlaces\GooglePlacesServiceProvider;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class GooglePlacesTest extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [GooglePlacesServiceProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return ['GooglePlaces' => GooglePlaces::class];
    }

    /**
     * Retourne le token de test.
     *
     * @return null|string
     */
    private function getTokenTest()
    {
        if ( file_exists(__DIR__ . '/../config/config.json') )
        {
            $fileConfigTest = file_get_contents(__DIR__ . '/../config/config.json');

            if ( !empty($fileConfigTest) )
            {
                $tokenTest = json_decode($fileConfigTest);

                if ( !empty($tokenTest->token) )
                {
                    return $tokenTest->token;
                }
            }
        }

        return NULL;
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $key = 'google_places_api';

        $app['config']->set("{$key}.TOKEN", $this->getTokenTest());

        var_dump($app['config']->get($key));
    }

    /**
     * Vérification que le token de l'API a bien été setté.
     */
    public function testTokenIfSetted()
    {
        $this->assertNotNull(app('GooglePlaces')->getTokenAPI());
    }
}