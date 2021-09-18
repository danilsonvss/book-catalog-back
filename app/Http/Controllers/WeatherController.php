<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function get(Request $request)
    {
        $key = '9b899196';
        $params = $request->only('lat', 'lon');
        $lat = $params['lat'];
        $lon = $params['lon'];

        $apiUrl = "https://api.hgbrasil.com/weather?key=$key&lat=$lat&lon=$lon";
        $res = file_get_contents($apiUrl);

        return $res;
    }
}
