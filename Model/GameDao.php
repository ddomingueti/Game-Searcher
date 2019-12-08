<?php
include_once "conexao.php";

class GameDao {

    public function findByGameName($gameName) { }

    public function findByGameDeveloper($gameDev) { }

    public function findAll() { 
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->find([]);
        $result = Conexao::getInstance()->getManager()->executeBulkWrite(Conexao::getDbName().'.publications.game.title', $bulk);
        return ($result->getDeletedCount() != 0);
    }

}