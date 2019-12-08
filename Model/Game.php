<?php

class Game implements JsonSerializable {
    
    private $name; //string
    private $minimumAge; // number
    private $isFree; // boolean
    private $type; // string - dlc, demo, full, etc
    private $developer; //string
    private $genres; // strings array
    private $requirements; // requirements object array
    private $platforms; // string array
    private $aboutGame; // string

    public function __construct($type="", $name="", $minumumAge="", $isFree="", $developer="", $genres="", $requirements="", $platforms="", $about="") {
        $this->setName($name);
        $this->setDeveloper($developer);
        $this->setGenres($genres);
        $this->setRequirements($requirements);
        $this->setPlatforms($platforms);
        $this->setType($type);
        $this->setMinimumAge($minumumAge);
        $this->setIsFree($isFree);
        $this->setAboutGame($about);
    }

    public function setName($value) { $this->name = $value; }
    public function setDeveloper($value) { $this->developer = $value; }
    public function setGenres($value) { $this->genres = $value; }
    public function setRequirements($value) { $this->requirements = $value; }
    public function setPlatforms($value) { $this->platforms = $value; }
    public function setType($value) { $this->type = $value; }
    public function setMinimumAge($value) { $this->minumumAge = $value; }
    public function setIsFree($value) { $this->isFree = $value; }
    public function setAboutGame($value) { $this->aboutGame = $value; }

    public function getName() { return $this->name; }
    public function getDeveloper() { return $this->developer; }
    public function getGenres() { return $this->genres; }
    public function getRequirements() { return $this->requirements; }
    public function getPlatforms() { return $this->platforms; }
    public function getType() { return $this->type; }
    public function getMinimumAge() { return $this->minimumAge; }
    public function getIsFree() { return $this->isFree; }
    public function getAboutGame() { return $this->aboutGame; }

    public function jsonSerialize() {
        return [
            'Data' => [$this->getType, $this->getName(), $this->getMinimumAge, $this->isFree],
            'AboutTheGame' => $this->getAboutGame(),
            'Developers' => $this->getDeveloper(),
            'Genres' => $this->getGenres(),
            'Platforms' => $this->getPlatforms(),
            'PcRequirements' => $this->requirements["Pc"] != null ? $this->requirements['Pc'] : [],
            'LinuxRequirements' => $this->requirements["Linux"] != null ? $this->requirements['Linux'] : [],
            'MacRequirements' => $this->requirements["Mac"] != null ? $this->requirements['Mac'] : [],
        ];
    }
}