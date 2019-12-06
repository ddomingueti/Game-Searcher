<?php
include_once "StoreDao.php";

class Store implements JsonSerializable {
    private $name;
    private $url;
    private $publications;

    public function __construct($name, $url) {
        $this->name = $name;
        $this->url = $url;
        $this->publications = [];
    }

    public function getName() { return $this->name; }
    public function setName($value) { $this->name = $value; }

    public function getUrl() { return $this->url; }
    public function setUrl($value) { $this->url = $value; }

    public function getPublications() { return $this->publications; }
    public function setPublications($value) { $this->publications = $value; }

    public function buscarTodas() {
        $storeDao = new StoreDao();
        $result = $storeDao->findAll();
        $stores = [];

    }

    public function jsonSerialize() {
        $arr_pub = [];
        if ($this->publications != null) {
            for ($i = 0; $i < count($this->publications); $i++) {
                $arr_pub.push($publications[$i].jsonSerialize());
            }
        }
        return [
            'name' => $this->getName(),
            'url' => $this->getUrl(),
            'publications' => $arr_pub,
        ];
    }
}