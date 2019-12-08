<?php

include_once "conexao.php";
include_once "StoreDao.php";

class PublicationDao {
    
    public function add($publicationObject, $storeId="") {
        $data = $publicationObject->jsonSerialize();
        if ($storeId != "")
            $data['storeId'] = $storeId;
        
        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        var_dump($result);
        return ($result->getInsertedCount() == 1);
    }

    public function findByStore($storeId) {
        
    }

    public function findByGameName($gamename) {

        return $cursor;
    }

    public function findOne($pubId) { 
        $data = ["__id" => $pubId, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publications', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

}