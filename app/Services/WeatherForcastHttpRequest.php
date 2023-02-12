<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherForcastHttpRequest {

    protected $city;
    protected $query = [];
    protected $response;
    protected $url;
    /**
     * Set the request queries
     * 
     * @return self
     */
    public function setQuery(array $query){
        $this->query = array_merge($this->query,$query);
        $this->url = config('weatherforecast.url');
        return $this;
    }

    /**
     * Main http request for getting the weather via ciy name
     * 
     * @return self
     */
    public function getByCityName(){
        $this->appendKeyId();
        $this->response = Http::get($this->url,$this->query);
        
        return $this;
    }

    /**
     * get the response
     * 
     * @return Http
     */
    public function getReponseStatus(){
        return $this->response->json('cod');
    }


    /**
     * Get the response in json formar
     * 
     * @return json
     */
    public function getJson(){
        return $this->response->json();
    }

    /**
     * Append the keyid on the request
     * 
     * @return void
     */
    public function appendKeyId(){
        $this->query['appid'] = config('weatherforecast.api-key');
    }
}

