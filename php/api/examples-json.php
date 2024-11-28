<?php
require_once('../app/dbconnect.php');
require_once('../app/ExampleList.php');
require_once('../app/CommandList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
$exList=new ExampleList();    
$exList->getAllFromDatabase($conn);
$commandList=new CommandList();    
$commandList->getAllFromDatabase($conn);
if($_SERVER['REQUEST_METHOD']=="POST"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->addToDatabase($conn,$exData);

} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->updateDatabaseRecord($conn,$exData);

} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->deleteFromDatabaseById($conn,$exData['id']);

}
echo $exList->exportAsJSON();