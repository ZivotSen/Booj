<?php

namespace App\Utils;

class Library
{
    private $initURL;

    public function __construct(){
        $this->initURL = "https://openlibrary.org/api";
    }

    /**
     * Makes a request to the Yelp API and returns the response
     *
     * @param $path         // The path of the API after the domain.
     * @param $parameters   // String of search parameters.
     * @return
     */
    public function getRequest($path, $parameters){
        // Send API Call
        $curl = curl_init();
        $url = $this->initURL . $path . "?" . $parameters . "&format=json";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
