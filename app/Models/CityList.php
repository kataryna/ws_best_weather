<?php

namespace App\Models;

use App\Models\City;

class CityList
{

    private $cityList;
    
    /**
     * Create list of objects City to managing, sorting and scoring them
     */   
    public function __construct($cities=array())
    {
        $this->cityList = $cities;
    }

    
    /**
     * Add new Object City to the list
     * 
     * @return void
    */     
    public function addCity(string $name, float $temperature, float $wind, int $humidity) 
    {
        
        $this->cityList[] = new City($name, $temperature, $wind, $humidity);
    }
    
    /**
     * Implement scoring algorithm for the list
     * 
     * @return void
    */
    public function countScores()
    {
        $this->countParameterScores('temperature',0.6);   
        $this->countParameterScores('wind',0.3);    
        $this->countParameterScores('humidity',0.1);
        
        foreach ($this->cityList as $city)
        {
            $city->countScore();
        }
        
        $this->sortByParameter('score');        
    }
        
    /**
     * Get current (sorted) list of cities
     * 
     * @return array
    */   
    public function getList()
    {
        return $this->cityList;
    }
     
    /**
     * Sort the list by given parameter and count score for each city in the list
     * 
     * @return void
     */
    private function countParameterScores(string $parameter, float $modifier)
    {
        $this->sortByParameter($parameter);
         
        $position_in_rank = 0;
                
        for($i=0; $i<count($this->cityList); $i++)
        {
            $score = (100 - 10 * $position_in_rank) * $modifier;
            $this->cityList[$i]->setScoreForParameter($parameter,  $score);
            
            //if value of parameter is the same, position in rank isn't incremented
            if($i < count($this->cityList)-1 && $this->cityList[$i]->$parameter != $this->cityList[$i+1]->$parameter)
            {
                $position_in_rank++;
            }
        }
    }
    
    /**
    * Sort the list by given parameter 
    * 
    * @return void
    */   
    private function sortByParameter(string $parameter)
    {
        switch($parameter) {
            case 'temperature':
                usort($this->cityList, function ($a, $b) {
                    //sort by value descending
                    return -($a->temperature <=> $b->temperature);   
                    });
                break;    
            
            case 'wind': 
                usort($this->cityList, function ($a, $b) {
                    //sort by value descending
                    return -($a->wind <=> $b->wind);   
                    });
                break;       
            
            case 'humidity': 
                usort($this->cityList, function ($a, $b) {
                    //sort by value descending
                    return -($a->humidity <=> $b->humidity);   
                    });
                break;      
            
            case 'score':
                usort($this->cityList, function ($a, $b) {
                    //sort by value descending
                    return -($a->score <=> $b->score);   
                    });
                break;     
        }
        
    }


    //
}
