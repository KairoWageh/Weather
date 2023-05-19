<?php

namespace App\Services;

use Illuminate\Support\Arr;

class WeatherService
{

    public function getWeather($search)
    {
        $url = config('weather.url');
        $apiKey = config('weather.apiKey');
        $apiUrl = $url."?key=$apiKey&q=$search";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return  json_decode($response);
        }
    }
}
