<?php

class ReleaseDate implements JsonSerializable {
    private $comingSoon;
    private $date;

    public function __construct($comingSoon, $date) {
        $this->commingSoon = $comingSoon;
        $this->date = $date;
    }

    public function getComingSoon() { return $this->comingSoon; }
    public function getDate() { return $this->date; }

    public function setComingSoon($value) { $this->comingSoon = $value; }
    public function setDate($value) { $this->date = $value; }

    public function jsonSerialize() {
        return [
            "coming_soon" => $this->comingSoon,
            "date" => $this->date,
        ];
    }
}