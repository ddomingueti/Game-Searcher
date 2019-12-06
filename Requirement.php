<?php

class Requirement implements JsonSerialize {

    private $os;
    private $cpu;
    private $video;
    private $sound;
    private $network;
    private $storage;

    public function __construct($os, $cpu, $video, $sound, $network, $storage) {
        $this->os = $os;
        $this->cpu = $cpu;
        $this->video = $video;
        $this->network = $network;
        $this->storage = $storage;
    }

    public function getOs() { return $this->os; }
    public function getCpu() { return $this->cpu; }
    public function getVideo() { return $this->video; }
    public function getSound() { return $this->sound; }
    public function getNetwork() { return $this->network; }
    public function getStorage() { return $this->storage; }

    public function setOs($value) { $this->os = $value; }
    public function setCpu($value) { $this->cpu = $value; }
    public function setVideo($value) { $this->video = $value; }
    public function setSound($value) { $this->sound = $value; }
    public function setNetwork($value) { $this->network = $value; }
    public function setStorage($value) { $this->storage = $value; }

    public function jsonSerialize() {
        return [
            'os' => $this->getOs(),
            'cpu' => $this->getCpu(),
            'video' => $this->getVideo(),
            'sound' => $this->getSound(),
            'network' => $this->getNetwork(),
            'storage' => $this->getStorage(),
        ];
    }

}