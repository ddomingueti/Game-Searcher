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
            $query["Data.0"] = new MongoDB\BSON\Regex($pubType, "i");
        if (isset($developer))
            $query["Developers"] = new MongoDB\BSON\Regex($developer, "i");
        if ($gen1 != null)
            $query["Genres"] = array('$in' => array(new MongoDB\BSON\Regex($gen1, "i")));
        if ($gen2 != null) {
            if (!isset($query['Genres']['$in'])) $query['Genres']['$in'] = [];
            array_push($query["Genres"]['$in'], new MongoDB\BSON\Regex($gen2, "i"));
        }
        if ($gen3 != null) {
            if (!isset($query['Genres']['$in'])) $query['Genres']['$in'] = [];
            array_push($query["Genres"]['$in'], new MongoDB\BSON\Regex($gen3, "i"));
        }
        if (isset($priceMin) && isset($priceMax)) {
            $data["Price.final"] = [ array ('$gte' => $priceMin), array('$lte' <= $priceMax) ];
        } else if (isset($priceMin) && !isset($priceMax)) {
            $data["Price.final"] = array('$gte' => $priceMin);
        } else {
            $data["Price.final"] = array('$lte' <= $priceMax);
        }

        //var_dump($query);

        $pubDao = new PublicationDao();
        $this->publication = $pubDao->customQuery($query);
        return count($this->publication > 0);
    }
}