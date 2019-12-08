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
        return $cursor;
    }

}