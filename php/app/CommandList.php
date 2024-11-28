<?php
require_once('../app/BaseList.php');
require_once('../app/Command.php');
class CommandList extends BaseList {
    public function add($params){
        if(isset($params['id'])){
            $this->id++;
        } else{
            $this->id++;
            $params['id']=$this->id;
        }
        $newObj=new Command($params);
        array_push($this->dataArray,$newObj);
    }

    public function exportAsArray(){
        $result=array(['command_name','description','category_id']);
        foreach($this->dataArray as $item){
            array_push($result,$item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML(){
        $result='<?xml version="1.0" encoding="UTF-8"?><commands>';
        foreach($this->dataArray as $item){
            $result.=$item->getAsXML();
        }
        $result.='</commands>';
        return $result;
    }

    public function exportAsDropdownItems(){
        $result='';
        foreach($this->dataArray as $item){
            
            $itemData=$item->getAsAssocArray();
            $result.='<option value="'.$itemData['id'].'">'.$itemData['command_name'].'</option>';
        }
        
        return $result;
    }
    public function readFromFile(){
        $row=0;
        if (($handle = fopen("../data/commands.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
              if($row>0){
                $dataArray=array('command_name'=>$data[0],'description'=>$data[1],'category_id'=>$data[2]);
                $this->add($dataArray);
              }
              $row++;
            }
            fclose($handle);
        }
            }

        public function saveToFile(){
            $fp = fopen('../data/commands.csv', 'w');
                foreach ($this->exportAsArray() as $row) {
                        fputcsv($fp, $row);
                }
                    fclose($fp);
            }

            public function getItemById($id){
                foreach($this->dataArray as $item){
                    if($item->getId()==$id){
                        return $item->getAsAssocArray();
                    }
                }
            }

            public function deleteFromDatabaseById($conn,$id){
                $stmt = $conn->prepare("DELETE from commands WHERE id=?");
                $stmt->bind_param("s", $id);
                $stmt->execute();
                return true;
            }

            public function addToDatabase($conn,$params){
                $stmt = $conn->prepare("INSERT INTO `commands` VALUES (DEFAULT,?,?,?)");
                $stmt->bind_param("sss", $command_name, $description,$category_id);
                $command_name = $params['command_name'];
                $description = $params['description'];
                $category_id = $params['category_id'];
                $stmt->execute();
                return true;
            }
    
            public function updateDatabaseRecord($conn, $params) {
                    $stmt = $conn->prepare("UPDATE `commands` SET `command_name`=?, `description`=?, `category_id`=? WHERE id=?");
                    $stmt->bind_param("ssss", $command_name, $description, $category_id, $id);
                    $command_name = $params['command_name'];
                    $description = $params['description'];
                    $category_id = $params['category_id'];
                    $id = $params['id']; 
                    $stmt->execute();
                    return true;
                }
                
    
            public function getAllFromDatabase($conn){
                $sql = "SELECT commands.*, categories.name AS category_id FROM commands INNER JOIN categories ON commands.category_id = categories.id";
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $this->add($row);
                    }
                }
            }
}