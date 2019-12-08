<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "StoreDao.php";

class PublicationDao {
    
    public function add($publicationObject, $storeId="") {
        if (gettype($publicationObject) == "object") {
            $data = $publicationObject->jsonSerialize();
        } else {
            $data = $publicationObject;
        }

        if ($storeId !== "") {
            $data['storeId'] = $storeId;
        }
        
        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.publications', $bulk);
        return ($result->getInsertedCount() == 1);
    }

    public function findByStore($storeId) {
        
    }

    public function findByGameName($gamename) {

        return $cursor;
    }

    public function findOne($pubId) { 
        $data = ["_id" => new MongoDB\BSON\ObjectID($pubId), ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function findAll() {
        $query = new MongoDB\Driver\Query([]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        
        $keys = array_keys($result);
        $arr = $result[$keys[0]]; // get the incoming data
        $store = new Store();
        $storeId = $arr->storeId;
        $store->findOne($storeId);
        $reqs = [];
        if (count($arr->PcRequirements) > 0) {   
            array_push($reqs, new Requirements("Pc", $arr->PcRequirements->minimum, $arr->PcRequirements->recommended));
        }
        if (count($arr->LinuxRequirements) > 0) {
            array_push($reqs, new Requirements("Linux", $arr->LinuxRequirements->minimum, $arr->LinuxRequirements->recomended));
        }
        if (count($arr->MacRequirements) > 0) {
            array_push($reqs, new Requirements("Mac", $arr->MacRequirements->minimum, $arr->MacRequiriments->recomended));                
        }

        $game = new Game($arr->Data[0], $arr->Data[1], $arr->Data[2], $arr->Data[2], $arr->Developers, $arr->Genres, $reqs, $arr->Platforms, $arr->AboutTheGame);
        
        $prices = [];
        if (count($arr->Prices) > 1) {
            foreach ($arr->Prices as $element) {
                $price = new Price($element->final, $element->currency, $element->formated);
                array_push($prices, $price);
            }
        } else {
            $prices = new Price($arr->Prices->final, $arr->Prices->currency, $arr->Prices->final_formatted);
        }

        $resources = [];
        $resoures["HeaderImage"] = $arr->HeaderImage;
        $resources["Screenshots"] = isset($arr->Screenshot) ? $arr->Screenshot : "Não há screenshots cadastradas.";
        $resources["Movies"] = $arr->Movies;

        $releaseDate = new ReleaseDate($arr->ReleaseDate->coming_soon, $arr->ReleaseDate->date);
        $this->setGame($game);
        $this->setPrice($prices);
        $this->setResources($resources);
        $this->setPubDate($releaseDate);
        $this->setStore($store);
        $this->setWebsite($arr->Website);
        $this->setDetailedDescription($arr->DetailedDescription);
        $this->setShortDescription($arr->ShortDescription);
        $this->setLanguages($arr->SupportedLanguages);
        $this->setMetacritic($arr->Metacritic);
        $this->setCategories($arr->Categories);
        $this->setRecomendations($arr->Recommendations);
        $this->_id = $_id;
    }

}