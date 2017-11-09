<?php

namespace MichaelLurquin\GooglePlaces;

use Illuminate\Config\Repository;
use MichaelLurquin\GooglePlaces\Utilities\Utilities;

class GooglePlaces
{
    use Utilities;

    /**
     * Config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $queries;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getTokenAPI()
    {
        return $this->config->get('google_places_api.TOKEN', NULL);
    }

    public function getEndpointAPI()
    {
        return $this->config->get('google_places_api.API_URL', NULL);
    }

    public function searchLocation(float $latitude, float $longitude, int $radius = 5000)
    {
        $this->queries['location'] = "{$latitude},{$longitude}";

        $this->queries['radius'] = $radius;

        return $this;
    }

    public function getTypes()
    {
        return [
            'accounting',
            'airport',
            'amusement_park',
            'aquarium',
            'art_gallery',
            'atm',
            'bakery',
            'bank',
            'bar',
            'beauty_salon',
            'bicycle_store',
            'book_store',
            'bowling_alley',
            'bus_station',
            'cafe',
            'campground',
            'car_dealer',
            'car_rental',
            'car_repair',
            'car_wash',
            'casino',
            'cemetery',
            'church',
            'city_hall',
            'clothing_store',
            'convenience_store',
            'courthouse',
            'dentist',
            'department_store',
            'doctor',
            'electrician',
            'electronics_store',
            'embassy',
            'fire_station',
            'florist',
            'funeral_home',
            'furniture_store',
            'gas_station',
            'gym',
            'hair_care',
            'hardware_store',
            'hindu_temple',
            'home_goods_store',
            'hospital',
            'insurance_agency',
            'jewelry_store',
            'laundry',
            'lawyer',
            'library',
            'liquor_store',
            'local_government_office',
            'locksmith',
            'lodging',
            'meal_delivery',
            'meal_takeaway',
            'mosque',
            'movie_rental',
            'movie_theater',
            'moving_company',
            'museum',
            'night_club',
            'painter',
            'park',
            'parking',
            'pet_store',
            'pharmacy',
            'physiotherapist',
            'plumber',
            'police',
            'post_office',
            'real_estate_agency',
            'restaurant',
            'roofing_contractor',
            'rv_park',
            'school',
            'shoe_store',
            'shopping_mall',
            'spa',
            'stadium',
            'storage',
            'store',
            'subway_station',
            'synagogue',
            'taxi_stand',
            'train_station',
            'transit_station',
            'travel_agency',
            'university',
            'veterinary_care',
            'zoo',
        ];
    }

    public function setType(string $type)
    {
        if ( in_array($type, $this->getTypes()) )
        {
            $this->queries['type'] = $type;

            return $this;
        }

        throw \Exception('Le type n\'existe pas !');
    }

    public function setLanguage(string $language)
    {
        $this->queries['language'] = $language;

        return $this;
    }

    public function get()
    {
        $this->queries['key'] = $this->getTokenAPI();

        $url = $this->getEndpointAPI() . '/nearbysearch/json?' . http_build_query($this->queries);

        $results = $this->getCurlResponse($url);

        $shops = $results->results;

        if ( !empty($results->next_page_token) )
        {
            sleep(2);

            $results = $this->next($results->next_page_token);

            $shops = array_merge($shops, $results->results);

            if ( !empty($results->next_page_token) )
            {
                sleep(2);

                $results = $this->next($results->next_page_token);

                $shops = array_merge($shops, $results->results);
            }
        }

        return $shops;
    }

    public function next(string $nextPageToken)
    {
        $this->queries = [];

        $this->queries['key'] = $this->getTokenAPI();

        $this->queries['pagetoken'] = $nextPageToken;

        $url = $this->getEndpointAPI() . '/nearbysearch/json?' . http_build_query($this->queries);

        return $this->getCurlResponse($url);
    }

    public function getDetailsShop(string $placeId, $language = 'fr')
    {
        $this->queries = [];

        $this->queries['placeid'] = $placeId;
        $this->queries['language'] = $language;

        $this->queries['key'] = $this->getTokenAPI();

        $url = $this->getEndpointAPI() . '/details/json?' . http_build_query($this->queries);

        return $this->getCurlResponse($url);
    }
}