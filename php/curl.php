<?php
    // create curl resource
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL, "http://localhost/PHP/api/categories-json.php");
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
    $data=json_decode($output,true);
    foreach ($data as $item){
        echo $item['id'].'. '.$item['name'].' - '.$item['description'].'</br>';
    }      

?>
    






