<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function weatherView()
    {
        return view('welcome');
    }

    public function getWeather(Request $request)
    {
        $validated = $request->validate([
            'search' => ['required']
        ], [
            'search.required' => 'Enter city name or zip code'
        ]);
        $weather = $this->weatherService->getWeather($validated['search']);
        $html = view('weather_table')->with([
            'weather_data' => $weather
        ])->render();
        return response()->json([
            'data' => $html
        ]);
    }
}
