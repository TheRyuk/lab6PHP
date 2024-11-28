<?php
header('Content-Type: text/xml; charset=utf-8');
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
require_once('../app/CategoryList.php');
$catList=new CategoryList();    
$row=0;
if (($handle = fopen("../data/categories.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('name'=>$data[0],'description'=>$data[1]);
        $catList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}
echo $catList->exportAsXML();