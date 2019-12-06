<?php

class Game implements JsonSerializable {
    
    private $name; //string
    private $developer; //string
    private $genres; // strings array
    private $requirements; // requirement object array
    private $platforms; // string array
    private $stores; // store object array

    public function __construct($name, $developer, $genres, $requiriments, $platforms) {
        $this->setName($name);
        $this->setDeveloper($developer);
        $this->setGenres($genres);
        $this->setRequiriments($requirements);
        $this->setPlatforms($platforms);
        $this->stores = [];
    }

    public function setName($value) { $this->name = $value; }
    public function setDeveloper($value) { $this->developer = $value; }
    public function setGenres($value) { $this->genres = $value; }
    public function setRequiriments($value) { $this->requirements = $value; }
    public function setPlatforms($value) { $this->platforms = $value; }
    public function setStores($value) { $this->stores = $value; }

    public function getName() { return $this->name; }
    public function getDeveloper() { return $this->developer; }
    public function getGenres() { return $this->genres; }
    public function getRequiriments() { return $this->requirements; }
    public function getPlatforms() { return $this->platforms; }
    public function getStores() { return $this->stores; }

    public function jsonSerialize() {
        $arr_requirements = [];
        $arr_stores = [];

        for($i=0; $i<count($this->requirements); $i++) {
            $arr_requirements.push($this->requirements[$i]->jsonSerialize());
        }

        for ($i=0; $i<count($this->stores); $i++) {
            $arr_stores.push($this->stores[$i]->jsonSerialize());
        }
        
        return [
            'name' => $this->getName(),
            'developer' => $this->getDeveloper(),
            'genres' => $this->getGenres(),
            'platforms' => $this->getPlatforms(),
            'requirements' => $this->requirements != null ? $arr_requirements : "",
            'stores' => $this->stores != null ? $array_stores : "",
        ];
    }
}