<?php
header('Content-Type: text/xml; charset=utf-8');
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
require_once('../app/ExampleList.php');
$exList=new ExampleList();    
$row=0;
if (($handle = fopen("../data/examples.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('command_id'=>$data[0],'example_code'=>$data[1],'description'=>$data[2]);
        $exList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}

echo $exList->exportAsXML();