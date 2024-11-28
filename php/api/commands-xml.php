<?php
header('Content-Type: text/xml; charset=utf-8');
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
require_once('../app/CommandList.php');
$commandList=new CommandList();    
$row=0;
if (($handle = fopen("../data/commands.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('command_name'=>$data[0],'description'=>$data[1],'category_id'=>$data[2]);
        $commandList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}
echo $commandList->exportAsXML();