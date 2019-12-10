<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "Comments.php";

class CommentsDao {
    public function add($commentObject, $pubId="") {
        $data = [];
        if (gettype($commentObject) == "object") {
            $data = $commentObject->jsonSerialize();
        } else {
            $data = $commentObject;
        }

        if ($pubId !== "") {
            $data['pubId'] = $pubId;
        }
        
        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.comments', $bulk);
        return ($result->getInsertedCount() == 1);
    }

    public function findOne($_id) {
        $data = ["_id" => new MongoDB\BSON\ObjectID($_id), ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function findAll() {
        $data = [];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();
        return $this->cursorToCommentList($cursor);
    }

    public function findByPubId($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToCommentList($cursor);
    }

    public function findByUsername($username) {
        $data = ["user" => $username, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments.user', $query);
        $cursor = $cursor->toArray();
        
        return $this->cursorToCommentList($cursor);
    }

    public function cursorToCommentList($cursor) {
        $final_comments = [];
        foreach ($cursor as $element) {
            $comment = new Comments($element->user, $element->steam_id, $element->recommendation, $element->date, $element->avatar, $element->hours, $element->review, $element->pubId);
            $comment->setStorageId((string)$element->_id);
            array_push($final_comments, $comment);                
        }
        return $final_comments; 
    }

   /* public function findSteamComments($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToCommentList($cursor);
    }

    public function findGogComments($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToCommentList($cursor);
    }*/

    public function findByPubIdRecent($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data, 'sort' => ['date'=>1]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToCommentList($cursor);
    }

    public function findByPubIdOld($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data, 'sort' => ['date'=>-1]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments', $query);
        $cursor = $cursor->toArray();

        return $this->cursorToCommentList($cursor);
    }

    public function sortByHours($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data, 'sort' => ['hours'=>1]);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();
        
        return $this->cursorToCommentList($cursor);
    }

    public function FindRecommended($id) {
        $data = ["pub_id" => $id, "recommendation" => "Recomendado"];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();
        
        return $this->cursorToCommentList($cursor);
    }

    public function FindNotRecommended($id) {
        $data = ["pub_id" => $id, "recommendation" => "Não Recomendado"];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.comments', $query);
        $cursor = $cursor->toArray();
        
        return $this->cursorToCommentList($cursor);
    }
}