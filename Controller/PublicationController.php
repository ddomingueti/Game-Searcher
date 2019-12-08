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

    public function findGameName() {

    }
}