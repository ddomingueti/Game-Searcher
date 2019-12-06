<?php

class GameDao {


    public function add($gameObject) {
        $requires = [];

        $data = [
            "name" => $gameObject->getName(),
            "developer" => $gameObject->getDeveloper(),
            
        ];
    }


    public function remove($gameId) { 

    }

    public function findByGameName($gameName) { }

    public function findByGameDeveloper($gameDev) { }

    public function findAll() { }

}