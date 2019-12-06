<?php

include_once "conexao.php";

class StoreDao {

    public function add($storeObject) {
        $data = [
            "name" => $store->getName(),
            "url" => $store->getUrl(),
            "publications" => $store->getPublications(),
        ];

        $bulk = new MongoDB\Driver\BulkWrite;
        $_id = $bulk->insert($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        var_dump($result);
        return ($result->getInsertedCount() == 1);
    }

    public function remove($storeId) {
        $data = ["__id" => $storeId, ];

        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete($data);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        return ($result->getDeletedCount() != 0);
    }

    public function update($storeObject) {
        $condition = ["name" => $storeObject->getName(), ];
        $values = ["set" => [ "name" => $storeObject->getName(), 
                             "url" => $storeObject->url, 
                             "publications" => $storeObject->getPublications(),
                            ],
                 ];
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update($condition, $values);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.stores', $bulk);
        return ($result->getModifiedCount() != 0);
    }

    public function findByName($storeName) {
        $data = ["name" => $storeName, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.stores', $query);
        $cursor = $cursor->toArray();
        
        return $cursor;
    }

    public function findAll() {
        $data = [];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.stores', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function findByPublication($pubId) { 
        $data = ["publication.__id" => $pubId, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.stores', $query);
        $cursor = $cursor->toArray();
        return $cursor;
    }

    public function findByGamePublication($gameId) {
        $data = [ "publication.game" => $gameId, ];
        $query = new MongoDB\Driver\Query($data);
        $cursor = Conexao::getInstance()->getManager()->executeQuery(Conexao::getDbName().'.stores', $query);
        $cursor = $cursor->toArray();
        var_dump($cursor);
        
        return $cursor;
    }

}

?>