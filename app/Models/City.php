<?php

namespace App\Models;

class City {
    /**
     * Create new City Object with weather parameters
     * 
     * @return void
     */
    public function __construct(string $name, float $temperature, float $wind, int $humidity) {
        $this->name = $name;
        $this->temperature = $temperature;
        $this->wind = $wind;
        $this->humidity = $humidity;
        $this->score_for_parameter = array();
        $this->score = null;
    }
    
    /**
     * Set partial score for the city 
     * string $parameter - 'temperature' or 'humidity' or 'wind'
     * int $score - score value for current parameter
     * 
     * @return void
     */
    public function setScoreForParameter(string $parameter, int $score) {
        $this->score_for_parameter[$parameter] = $score;
    }

    /**
     * Count final score for the city
     * 
     * @return int $store 
     */
    public function countScore() {
        $this->score = array_sum($this->score_for_parameter);
        return $this->score;
    }

}
