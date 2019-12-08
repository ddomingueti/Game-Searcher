<?php

class Game implements JsonSerializable {
    
    private $name; //string
    private $type; // string - dlc, demo, full, etc
    private $developer; //string
    private $genres; // strings array
    private $requirements; // requirements object array
    private $platforms; // string array

    public function __construct($name, $developer, $genres, $requiriments, $platforms, $type) {
        $this->setName($name);
        $this->setDeveloper($developer);
        $this->setGenres($genres);
        $this->setRequiriments($requirements);
        $this->setPlatforms($platforms);
        $this->setType($type);
    }

    public function setName($value) { $this->name = $value; }
    public function setDeveloper($value) { $this->developer = $value; }
    public function setGenres($value) { $this->genres = $value; }
    public function setRequiriments($value) { $this->requirements = $value; }
    public function setPlatforms($value) { $this->platforms = $value; }
    public function setType($value) { $this->type = $value; }

    public function getName() { return $this->name; }
    public function getDeveloper() { return $this->developer; }
    public function getGenres() { return $this->genres; }
    public function getRequiriments() { return $this->requirements; }
    public function getPlatforms() { return $this->platforms; }
    public function getType() { return $this->type; }

    public function jsonSerialize() {
        return [
            'name' => $this->getName(),
            'developer' => $this->getDeveloper(),
            'type' => $this->getType(),
            'genres' => $this->getGenres(),
            'platforms' => $this->getPlatforms(),
            'PcRequirements' => $this->requirements["Pc"] != null ? $this->requirements['Pc'] : [],
            'LinuxRequirements' => $this->requirements["Linux"] != null ? $this->requirements['Linux'] : [],
            'MacRequirements' => $this->requirements["Mac"] != null ? $this->requirements['Mac'] : [],
        ];
    }
}