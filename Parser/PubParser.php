<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";

$store = new Store("", "", "");
//$store->createInstance();

$r = $store->findOne('5ded6077256e0000500057ad');

$publication = new Publication();
$r = $publication->findOne('5ded6262256e0000500057ae');
var_dump($r);
var_dump($publication);

/*
$json = file_get_contents("$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Data/info.json", true);
$json = json_decode($json, true);
$keys = array_keys($json);
$json = $json[$keys[0]];
$pubDao = new PublicationDao();
$pubDao->add($json, $store->getStoreId());
*/