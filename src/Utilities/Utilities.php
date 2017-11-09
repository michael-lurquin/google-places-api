<?php

namespace MichaelLurquin\GooglePlaces\Utilities;

trait Utilities
{
    /**
     * Renvoi le code HTTP de réponse de l'url.
     *
     * @param string $url
     * @return int
     */
    public function getHttpResponseCode(string $url)
    {
        $headers = get_headers($url);

        if ( !empty($headers[0]) )
        {
            return (int) substr($headers[0], 9, 3);
        }

        return 0;
    }

    /**
     * Renvoi le body de la requête HTTP.
     *
     * @param string $url
     * @return mixed
     */
    public function getCurlResponse(string $url)
    {
        if ( $this->getHttpResponseCode($url) )
        {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_URL => $url,
            ]);

            $result = curl_exec($ch);
            curl_close($ch);

            $output = json_decode($result);

            return !empty($output->status) && $output->status === 'OK' ? $output : $output->status;
        }

        return FALSE;
    }
}