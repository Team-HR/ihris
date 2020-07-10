<?php

if(isset($_POST["getImage"])){
    $img = $_POST['imgBase64'];
    $infos = $_POST["infos"];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    $fileName = 'takay_1x1/'.$infos["id"].'.jpeg';
    file_put_contents($fileName, $fileData);
    echo json_encode($infos);
}

?>