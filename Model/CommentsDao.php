<?php

include_once "conexao.php";
include_once "Commments.php";

class CommentsDao {
    public function add($comentObject) {
        $data = $comentObject->jsonSerialize();
        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        var_dump($result);
        return ($result->getInsertedCount() == 1);
    }

    public function findOne($pubId, $__id) {
        $data = ["pub_id" => $pubId, "__id" => $__id, ];
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
        if (count($cursor) > 0) {
            $final_comments = [];
            foreach ($cursor as $element) {
                $comment = new Comment($element->user, $element->steam_id, $element->recommendation, $element->date, $element->avatar, $element->hours, $element->review, $pubId);
                array_push($final_comments, $comment);                
            }
            return $final_comments; 
        } else { 
            return null;
        }
    }

    public function findByPubId($id) {
        $data = ["pub_id" => $id];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function findByUsername($username) {
        $data = ["username" => $username, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'comments.user', $query);
        $cursor = $cursor->toArray();
        
        $final_comments = [];
        foreach ($cursor as $element) {
            $comment = new Comments($element->username, $element->reactions, $element->text, $element->title);
            array_push($final_comments, $comment);
        }
        return $final_comments;
    }
}