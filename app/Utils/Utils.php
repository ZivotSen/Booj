<?php

namespace App\Utils;

// PHP Utils
trait Utils
{
    // Function to know if a value is in a correct json format
    public static function isJSON($string) {
        if(is_array($string)){
            return false;
        }
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    // Function to convert a json into array
    public static function jsonToArray($string){
        if(self::isJSON($string)){
            return json_decode($string, true);
        }
        return false;
    }

    // Simple curl request
    public static function getRequest($url, $method, $data = null, $isJSON = false){
        if(isset($url) && isset($method)){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            if(isset($data) && $isJSON){
                $data = json_encode($data);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            }
            if(strtoupper($method) == "POST"){
                curl_setopt($curl, CURLOPT_POST, 1);
                if($data){
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
            }

            $result = curl_exec($curl);
            curl_close ($curl);

            if($result && !is_null($result)){
                return $result;
            }
        }
        return false;
    }
}
