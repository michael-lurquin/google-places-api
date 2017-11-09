<?php

return [
    'debug' => env('APP_DEBUG', FALSE),

    'API_URL' => 'https://maps.googleapis.com/maps/api/place',

    'TOKEN' => env('GOOGLE_PLACES_API_TOKEN', ''),
];