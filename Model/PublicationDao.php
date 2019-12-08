<?php

include_once "conexao.php";

class PublicationDao {
    
    public function add($publicationObject, $storeId) {
        $data = $publicationObject->jsonSerialize();
        $data['storeId'] = $storeId;
        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        var_dump($result);
        return ($result->getInsertedCount() == 1);
    }

    public function remove($pubId, $storeId) {
        $data = [ "__id" => $pubId, "storeId" => $storeId, ];
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.publication', $bulk);
        return ($result->getDeletedCount() != 0);
    }

    public function findByStore($storeId) {
        
    }

    public function findByGameName($gamename) {

        return $cursor;
    }

    public function findByPublication($pubId) { 
        $data = ["__id" => $pubId, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.publication', $query);
        $cursor = $cursor->toArray();

        return $cursor;
    }

}