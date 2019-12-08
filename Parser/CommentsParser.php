<?php


include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/conexao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Model/Comments.php";

$comment = new CommentsDao();


$json = file_get_contents("$_SERVER[DOCUMENT_ROOT]/Game-Searcher/Data/Page1Reviews.json", true);
$json = json_decode($json, true);
var_dump($json);
$commentDao = new CommentsDao();

foreach ($json as $element) {
    $commentDao->add($element, "5ded6262256e0000500057ae");    
}
