<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Comments.php";

class CommentController {

    private $comment;

    public function __construct() {
        $this->comment = new Comments();
    }

    public function getComment() { return $this->comments; }

    public function findById($id) {
        $r = $this->comment->findOne($id);
        return $r;
    }

    public function findByPubId($pubId) {
        $r = $this->comment->findByPubId($pubId);
        return $r;
    }

    public function findAll() {
        return $this->comment->findAll();
    }
}