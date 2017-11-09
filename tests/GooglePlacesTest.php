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

//        var_dump($app['config']->get($key));
    }

    /**
     * Vérification que le token de l'API a bien été setté.
     */
    public function testTokenIfSetted()
    {
        $response = app('GooglePlaces')->getTokenAPI();

        $this->assertNotNull($response);
    }

    public function testResultAPI()
    {
        $response = app('GooglePlaces')->searchLocation(51.105516, 2.650142)->setType('restaurant')->get();

        $restaurants = array_column($response, 'place_id', 'name');

        dd(array_keys($restaurants));

        if ( !empty($restaurants) )
        {
            foreach($restaurants as $name => $placeId)
            {
                var_dump($name, $placeId);
                echo PHP_EOL;
                $details = app('GooglePlaces')->getDetailsShop($placeId);
                dd($details);
            }
        }

        $this->assertNotNull($response);
    }
}