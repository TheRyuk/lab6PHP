<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require_once('./app/CategoryList.php');
require_once('./app//CommandList.php');
require_once('./app//ExampleList.php');

$catList=new CategoryList();    
$row=0;
if (($handle = fopen("./data/categories.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('name'=>$data[0],'description'=>$data[1]);
        $catList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}
$catList->display();


$cmdList=new CommandList();    
$row=0;
if (($handle = fopen("./data/commands.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('command_name'=>$data[0],'description'=>$data[1],'name'=>$data[2]);
        $cmdList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}
$cmdList->display(); 
  
$exList=new ExampleList();    
$row=0;
if (($handle = fopen("./data/examples.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if($row>0){
        $dataArray=array('example_code'=>$data[0],'description'=>$data[1]);
        $exList->add($dataArray);
      }
      $row++;
    }
    fclose($handle);
}
$exList->display();      

$fp = fopen('./data/categories.csv', 'w');
foreach ($catList->exportAsArray() as $row) {
    fputcsv($fp, $row);
}
fclose($fp);


$fp = fopen('./data/commands.csv', 'w');
foreach ($cmdList->exportAsArray() as $row) {
    fputcsv($fp, $row);
}
fclose($fp);

$fp = fopen('./data/examples.csv', 'w');
foreach ($exList->exportAsArray() as $row) {
    fputcsv($fp, $row);
}
fclose($fp);
/*
echo "<h3>Категорії команд:</h3>";
$categoryData1 = ['name' => 'Файлові команди', 'description' => 'Команди для роботи з файлами'];
$categoryData2 = ['name' => 'Мережеві команди', 'description' => 'Команди для роботи з мережею'];
$catList = new CategoryList();
$catList->add($categoryData1);
$catList->add($categoryData2);
$catList->display();
echo "<h3>Список команд:</h3>";
$commandData1 = ['command_name' => 'ls', 'description' => 'Перегляд вмісту директорії', 'name' => 'Файлові команди'];
$commandData2 = ['command_name' => 'pwd', 'description' => 'Виведення поточного шляху', 'name' => 'Файлові команди'];
$cmdList = new CommandList();
$cmdList->add($commandData1);
$cmdList->add($commandData2);
$cmdList->display();

echo "<h3>Приклади використання команд:</h3>";
$exampleData1 = ['example_code' => 'ls -lh', 'description' => 'Перегляд вмісту з розмірами файлів'];
$exampleData2 = ['example_code' => 'pwd', 'description' => 'Показує поточний шлях'];
$exList = new ExampleList();
$exList->add($exampleData1);
$exList->add($exampleData2);
$exList->add($exampleData2);
$exList->update(['id' => 2, 'example_code' => 'ls -hase', 'description' => 'Перегляд хешу']);
$exList-> delete(1);
$exList->display();
*/
?>

