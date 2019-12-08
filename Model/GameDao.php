<?php
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";

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