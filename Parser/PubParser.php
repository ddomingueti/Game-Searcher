<?php

include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Publication.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Comments.php";

function addInfoSteam($path, $storeId) {
    $json = file_get_contents($path, true);
    $json = json_decode($json, true);
    $keys = array_keys($json);
    $json = $json[$keys[0]];
    $json['numSearches'] = 0;
    $pubDao = new PublicationDao();
    $id = $pubDao->add($json, $storeId);
    return $id;
}

function addCommentSteam($path, $pubId) {    
    $json = file_get_contents($path, true);
    $json = json_decode($json, true);
    $commentDao = new CommentsDao();
    foreach ($json as $element) {
        $commentDao->add($element, $pubId);    
    }
}


$store = new Store("", "", "");
$r = $store->findByName('Steam'); //steam id
$base_path = "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Data/Daniel";
$cont = 1;
$d = dir($base_path);
$pub_id = "";
while (false !== ($entry = $d->read())) {
   if ($entry == "." || $entry == "..") continue;
   if (is_dir($base_path."/".$entry)) {
        $child = dir($base_path."/".$entry);
        while (false !== ($childEntry = $child->read())) {
            if ($childEntry == "." || $childEntry == "..") continue;
            
            if ($childEntry == "info.json") {
                $pub_id = addInfoSteam($child->path."/".$childEntry, $store->getStoreId());
            }
            else addCommentSteam($child->path."/".$childEntry, $pub_id);
        }
        $child->close();
   }
   $cont = $cont + 1;
}

$d->close();

echo 'A --- C --- A --- B --- O --- U ';