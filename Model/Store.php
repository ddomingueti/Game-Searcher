<?php
include_once "StoreDao.php";

class Store implements JsonSerializable {
    private $name;
    private $url;
    private $_id;

    public function __construct($__id="", $name="", $url="") {
        $this->name = $name;
        $this->url = $url;
        $this->_id = $__id;
    }

    public function getName() { return $this->name; }
    public function setName($value) { $this->name = $value; }

    public function getUrl() { return $this->url; }
    public function setUrl($value) { $this->url = $value; }

    public function getStoreId() { return $this->_id; }
    public function setStoreId($value) { $this->_id = $value; }

    public function findAll() {
        $storeDao = new StoreDao();
        $result = $storeDao->findAll();
        return $result;
    }

    public function findOne($__id) {
        $storeDao = new StoreDao();
        $result = $storeDao->findOne($__id);
        if (count($result) > 0) {
            $this->setStoreId((string)$result[0]->_id);
            $this->setName($result[0]->name);
            $this->setUrl($result[0]->url);
            return true;
        } else {
            return false;
        }
    }

    public function findByName($storeName) {
        $storeDao = new StoreDao();
        $result = $storeDao->findByName($storeName);
        if (count($result) > 0) {
            $this->setStoreId((string)$result[0]->_id);
            $this->setName($result[0]->name);
            $this->setUrl($result[0]->url);
            return true;
        } else {
            return false;
        }
    }

    public function createInstance() {
        $storeDao = new StoreDao();
        $result = $storeDao->add($this);
        return $result;
    }

    public function updateInstance() {
        $storeDao = new StoreDao();
        $result = $storeDao->update($this);
        return $result;
    }

    public function deleteInstance() {
        $storeDao = new StoreDao();
        $result = $storeDao->remove($this->storeId);
        return $result;
    }

    public function jsonSerialize() {
        return [
            'name' => $this->getName(),
            'url' => $this->getUrl(),
        ];
    }
}