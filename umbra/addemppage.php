<?php
   require_once "../_connect.db.php";
  if(isset($_POST['addemppage'])){
    $empid =$mysqli->real_escape_string($_POST['empid']);
    $prrid =$mysqli->real_escape_string($_POST['prrid']);

    $sql = "INSERT INTO `prrlist`
          (`prrlist_id`, `prr_id`, `employees_id`, `date_submitted`, `appraisal_type`, `date_appraised`, `numerical`, `adjectival`, `remarks`, `comments`,`stages`)
          VALUES (NULL, '$prrid', '$empid', '', '', '', '', '', '', '','C')";
    $mysqli->query($sql);
  }else{

  }

 ?>
