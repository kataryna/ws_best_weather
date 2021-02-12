<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Models\CityList;

class WeatherApiController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->EXTERNAL_WEATHER_API = array (
            'url' =>'http://api.openweathermap.org/data/2.5/weather', 
            'key'=>'4e2c1bf2de8139abcf1bd84e27cd6c72'
            );
    }
    
    /**
     *
     * @param string $query - example: "Gdańsk|Gdynia|Sopot"
     */
    public function index($query)
    {
        $city_names = explode(';', urldecode($query)); 
        
        $appClient = new Client();
        $cityList = new CityList();        
        $result['datetime'] = date("Y-m-d H:i:s");
        
        foreach ($city_names as $city_name)
        {       

                //get weather data about the city from external api
                $response = $appClient->request('GET',$this->EXTERNAL_WEATHER_API['url'] , 
                        ['query' => ['q' => $city_name, 'APPID' => $this->EXTERNAL_WEATHER_API['key']]]
                        );
                $row = json_decode($response->getBody());
                
                $cityList->addCity(
                        $row->name, 
                        $row->main->temp, 
                        $row->wind->speed, 
                        $row->main->humidity
                        );

 
        }
        
        $cityList->countScores();
        $result['cities'] = $cityList->getList();
        return response()->json($result);
    }
    

    //
}
