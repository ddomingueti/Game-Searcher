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
        return (string)$_id;
    }

    public function findByStore($storeId) {
        $data = ["storeId" => $storeId,];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $this->cursorToPubList($cursor);
    }

    public function findByGameName($gamename) {
        $data = array('Data.1' => new MongoDB\BSON\Regex($gamename, "i"));
        $filter = array( 'sort' => array( 'OrderBy' => -1 ) );
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query, $filter);
        $cursor = $cursor->toArray();
        return $this->cursorToPubList($cursor);
    }

    public function findByPrice($min, $max) {
        $data["Price.final"] = [ array ("gte" => $min), array("lte" => $max) ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $this->cursorToPubList($cursor);
    }

    public function findOne($pubId) { 
        $data = ["_id" => new MongoDB\BSON\ObjectID($pubId), ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function customQuery($data) {
        $filter = array( 'sort' => array( 'OrderBy' => -1 ));

        $query = new MongoDB\Driver\Query($data, $filter);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        var_dump($cursor);
        return $this->cursorToPubList($cursor);
    }

    public function findAll() {
        $query = new MongoDB\Driver\Query([]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        $pub_list = $this->cursorToPubList($cursor);
        return $pub_list;
    }

    public function findByGenres($genre1, $genre2, $genre3) {
        $data["Genres"] = array("in" => array($gen1, $gen2, $gen3));
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $this->cursorToPubList($cursor);        
    }

    public function findByVisited() {
        $data = [];
        $query = new MongoDB\Driver\Query($data, ['sort' => ['numSearches'=>1]]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToPubList($cursor);
    }

    public function cursorToPubList($cursor) {
        $pubs = [];
        foreach ($cursor as $element) {
            $keys = array_keys($cursor);
            $arr = $element; // get the incoming data
            $reqs = [];
            if (isset($arr->PcRequirements) && count($arr->PcRequirements) > 0) {
                $minimum = "";
                $recommended = "";
                if (isset($arr->PcRequirements->minimum)) $minimum = $arr->PcRequirements->minimum;
                if (isset($arr->PcRequirements->recommended)) $recommended = $arr->PcRequirements->recommended;
                array_push($reqs, new Requirements("Pc", $minimum, $recommended));
            }
            if (isset($arr->LinuxRequirements) && count($arr->LinuxRequirements) > 0) {
                $minimum = "";
                $recommended = "";
                if (isset($arr->LinuxRequirements->minimum)) $minimum = $arr->LinuxRequirements->minimum;
                if (isset($arr->LinuxRequirements->recommended)) $recommended = $arr->LinuxRequirements->recommended;
                array_push($reqs, new Requirements("Linux",$minimum, $recommended));
            }
            if (count(isset($arr->MacRequirements) && $arr->MacRequirements) > 0) {
                $minimum = "";
                $recommended = "";
                if (isset($arr->MacRequirements->minimum)) $minimum = $arr->MacRequirements->minimum;
                if (isset($arr->MacRequirements->recommended)) $recommended = $arr->MacRequirements->recommended;
                array_push($reqs, new Requirements("Mac", $minimum, $recommended));                
            }
            
            $game = new Game($arr->Data[0], $arr->Data[1], $arr->Data[2], $arr->Data[2], $arr->Developers, $arr->Genres, $reqs, $arr->Platforms, $arr->AboutTheGame);
            
            $prices = [];
            if (isset($arr->Prices)) {
                if (count($arr->Prices) > 1) {
                    foreach ($arr->Prices as $element) {
                        $price = new Price($element->final, $element->currency, $element->formated);
                        array_push($prices, $price);
                    }
                } else {
                    $currency = "";
                    $final_formatted = "";
                    $final = "";
                    if (isset($arr->Prices->final)) $final = $arr->Prices->final;
                    if (isset($arr->Prices->currency)) $currency = $arr->Prices->currency;
                    if (isset($arr->Prices->final_formatted)) $final_formatted = $arr->Prices->final_formatted;
                    if ($currency == "" && $final_formatted == "" && $final = "") $final_formatted = $arr->Prices;
                    $prices = new Price($final, $currency, $final_formatted);
                }
            }

            $resources = [];
            
            $resoures["HeaderImage"] = isset($arr->HeaderImage) ? $arr->HeaderImage : "";
            $resources["Screenshots"] = isset($arr->Screenshot) ? $arr->Screenshot : "Não há screenshots cadastradas.";
            $resources["Movies"] = isset($arr->Movies) ? $arr->Movies : "";
            $releaseDate = "";
            if (isset($arr->ReleaseDate)) {
                $releaseDate = new ReleaseDate($arr->ReleaseDate->coming_soon, $arr->ReleaseDate->date);
            }
            $store = new Store();
            $store->findOne($arr->storeId);

            $pub = new Publication();
            $pub->setGame($game);
            $pub->setPrice($prices);
            $pub->setResources($resources);
            $pub->setPubDate($releaseDate);
            $pub->setStore($store);
            $pub->setWebsite($arr->Website);
            if (isset($arr->DetailedDescription))
                $pub->setDetailedDescription($arr->DetailedDescription);
            if (isset($arr->ShortDescription))
                $pub->setShortDescription($arr->ShortDescription);
            if (isset($arr->SupportedLanguages))
                $pub->setLanguages($arr->SupportedLanguages);
            if (isset($arr->Metacritic))
                $pub->setMetacritic($arr->Metacritic);
            if (isset($arr->Categories))
                $pub->setCategories($arr->Categories);
            if (isset($arr->Recommendations))   
                $pub->setRecomendations($arr->Recommendations);
            
            if (isset($arr->numSearches))
                $pub->setNumSearches($arr->numSearches);

            $pub->setPublicationId($arr->_id);
            array_push($pubs, $pub);
        }
        return $pubs;

    }
}