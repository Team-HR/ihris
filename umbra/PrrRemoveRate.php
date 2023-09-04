<?php
require "../_connect.db.php";

$sql = "DELETE FROM `prrlist` WHERE `prrlist`.`prrlist_id` = $_POST[prrDataRemove]";
$sql = $mysqli->query($sql);
if(!$sql){
  echo $mysqli->error;
}else{
  echo 1;
}



?>
