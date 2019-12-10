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

    public function customSearch($gen1, $gen2, $gen3, $pubType, $dev, $priceMin, $priceMax) {
        $query = [];
        if (isset($pubType))
            $query["Data.[0]"] = $pubType;
        if (isset($developer))
            $query["Developers"] = new MongoDB\BSON\Regex("/".$developer."/");
        if (isset($genre))
            $query["Genres"] = array("in" => array($gen1, $gen2, $gen3));
        if (isset($priceMin) && isset($priceMax)) {
            $data["Price.final"] = [ array ("gte" => $priceMin), array("lte" => $priceMax) ];
        } else if (isset($priceMin) && !isset($priceMax)) {
            $data["Price.final"] = array("gte" => $priceMin);
        } else {
            $data["Price.final"] = array("lte" => $priceMax);
        }
        
        $pubDao = new PublicationDao();
        $this->publication = $pubDao->customQueryPublication($query);
    }
}