<?php
require_once('../app/dbconnect.php');
require_once('../app/CommandList.php');
header('Content-Type: application/json; charset=utf-8');
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
$commandList=new CommandList();    
$commandList->getAllFromDatabase($conn);
if($_SERVER['REQUEST_METHOD']=="POST"){
    $commandData=json_decode(file_get_contents('php://input'), TRUE);
    $commandList->addToDatabase($conn,$commandData);

} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $commandData=json_decode(file_get_contents('php://input'), TRUE);
    $commandList->updateDatabaseRecord($conn,$commandData);

} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $commandData=json_decode(file_get_contents('php://input'), TRUE);
    $commandList->deleteFromDatabaseById($conn,$commandData['id']);

}
echo $commandList->exportAsJSON();
