<?php


include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";

$pubDao = new PublicationDao();

$r = $pubDao->findByGameName("Age of Darkness: Die Suche nach Relict");
var_dump($r);

