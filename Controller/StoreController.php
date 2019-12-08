<?php
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Store.php";

class StoreController {

    private $store;

    public function __construct() {
        $this->store = new Store();
    }

    public function getStore() { return $this->store; }
    
    public function findStore($storeName="", $storeId="") {
        if ($storeId === "")
            $r = $this->store->findByName($storeName);
        else if ($storeName === "")
            $r = $this->store->findOne($storeId);
        else {
            $storeDao = new StoreDao();
            $r = $storeDao->findAll();
        }
        return $r;
    }

}