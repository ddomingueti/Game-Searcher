<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";

class PublicationController {

    private $publication;

    public function __construct() {
        $this->publication = new Publication();
    }

    public function getPublication() { return $this->publication; }

    public function findPublication($pubdId) {
        $r = $publication->findOne($pubdId);
        return $r;
    }

    public function findGameName($gameName) {
        $publicationDao = new PublicationDao();
        $this->publication = $publicationDao->findByGameName($gameName);
        return (count($this->publication) > 0);
    }

    public function findVisitedPubs() {
        $publicationDao = new PublicationDao();
        $this->publication = $publicationDao->findByVisited();
        return (count($this->publication) > 0);
    }

    public function customSearch($gameName, $pubType, $minAge, $developer, $genres, $categories, $storeName, $languages, $priceMin, $priceMax, $pubDate, $hasMetacritic, $recomendations) {
        $query = [];
        if (isset($gameName))
            $query['Data.[1]'] = $gameName;
        if (isset($pubType))
            $query["Data.[0]"] = $pubType;
        if (isset($minAge))
            $query["Data.[2]"] = $minAge;
        if (isset($developer))
            $query["Developers"] = $developer;
        if (isset($genre))
            $query["Genres"] = $genres;
        if (isset($categories))
            $query["Categories"] = $categories;
        if (isset($storeName)) {
            $store = new Store();
            $store->findByName($storeName);
            $query["storeId"] = $store->getStoreId();
        }
        if (isset($languages))
            $query["Languages"] = $languages;
        
        $pubDao = new PublicationDao();
        $this->publication = $pubDao->customQueryPublication($query);
        
    }
}