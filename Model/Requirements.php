<?php

class Requirements implements JsonSerializable {
    private $platform;
    private $minimum;
    private $recommended;

    public function __construct($platform="", $minimum="", $recommended="") {
        $this->setPlatform($platform);
        $this->setMiminum($minimum);
        $this->setRecommended($recommended);
    }

    public function setPlatform($value) { $this->platform = $value; }
    public function setMiminum($value) { $this->minimum = $value; }
    public function setRecommended($value) { $this->recommended = $value; }

    public function getPlatform() { return $this->platform; }
    public function getMinimum() { return $this->minimum; }
    public function getRecommended() { return $this->recommended; }

    public function jsonSerialize() {
        return [
            "minimum" => $this->getMinimum(),
            "recommended" => $this->getRecommended,
        ];
    }
}