<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\WeatherForecastRequest;
use App\Services\WeatherForcastHttpRequest;

class WeatherForecastController extends Controller
{
    protected $weatherForecastHttRequest;
    
    public function __construct(WeatherForcastHttpRequest $weatherForecastHttRequest){
        $this->weatherForecastHttRequest = $weatherForecastHttRequest;
    }
    /**
     * Send a Request to weather api and get the response
     * 
     * @return JsonResponse $response
     */
    public function getWeather(WeatherForecastRequest $request){
        $query = ['q' => $request->query('search')];
        $response = $this->weatherForecastHttRequest
                         ->setQuery($query)
                         ->getByCityName();

        $statusIsOk = $response->getReponseStatus() === 200;        
        $status = $response->getReponseStatus();
        $data['status'] = $status;
        $data['message'] = $statusIsOk ? "success" : "Place does not exist";

        return response()->json([
            'forecast' => $statusIsOk ? $response->getJson() : $data,
        ]);
    }
}
