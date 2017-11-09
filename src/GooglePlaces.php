<?php

namespace MichaelLurquin\GooglePlaces;

use Illuminate\Config\Repository;

class GooglePlaces
{
    /**
     * Config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getTokenAPI()
    {
        return $this->config->get('google_places_api.TOKEN', NULL);
    }
}