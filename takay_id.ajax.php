<?php
require "_connect.db.php";

if(isset($_POST["getImage"])){
    $img = $_POST['imgBase64'];
    $infos = $_POST["infos"];


$sql = "INSERT INTO `takays` (`id`, `last_name`, `first_name`, `middle_name`, `ext_name`, `address`, `gender`, `date_of_birth`, `place_of_birth`, `contact_no`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('isssssssss',$infos["id"],$infos["last_name"],$infos["first_name"],$infos["middle_name"],$infos["ext_name"],$infos["address"],$infos["gender"],$infos["date_of_birth"],$infos["place_of_birth"],$infos["contact_no"]);

$stmt->execute();


    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    $fileName = 'takay_1x1/'.$infos["id"].'.jpeg';
    file_put_contents($fileName, $fileData);
    echo json_encode($infos);
}

?>