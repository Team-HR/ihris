<?php
    require_once "../../_connect.db.php";

    if (isset($_POST['positions'])) {
        $sql = "SELECT * from `positiontitles` ORDER BY `positiontitles`.`position` ASC";
        $sql = $mysqli->query($sql);  
        if(!$sql){
            echo $mysqli->error;
        }else{
            $a = [];
            while($ar = $sql->fetch_assoc()){
                $a[] = $ar;
            }
            echo json_encode($a);
        }
    }elseif (isset($_POST['qs'])) {
        echo json_encode(qualification_standards());
    }elseif (isset($_POST['saveQS'])) {
        $positionID = $mysqli->real_escape_string($_POST['positionID']);
        $education = $mysqli->real_escape_string($_POST['education']);
        $experience = $mysqli->real_escape_string($_POST['experience']);
        $training = $mysqli->real_escape_string($_POST['training']);
        $eligibility = $mysqli->real_escape_string($_POST['eligibility']);
        $competency = $mysqli->real_escape_string($_POST['competency']);
        $status = "success";
        if($_POST['saveQS']!=""&&$_POST['saveQS']!=0){
            $sql = "UPDATE `qualification_standards` set `education`='$education' , `experience`='$experience', `training`='$training',`eligibility`='$eligibility',`competency`='$competency' where  `id`='$_POST[saveQS]'";       
            $msg = "Data are successfully modified";
        }else{
            $sql = "INSERT into `qualification_standards` (`id`,`position_id`,`education`,`experience`,`training`,`eligibility`,`competency`) values ('','$positionID','$education','$experience','$training','$eligibility','$competency')";
            $msg = "Data are successfully saved";
        }
        $sql = $mysqli->query($sql);
        if(!$sql){
            $msg = "ERROR:".$mysqli->error;
            $status = "error";
            $qs = [];
        }else{
            $qs = qualification_standards();
        }
        $a =  array('msg' => $msg,'status' => $status ,'QS' => $qs);
        echo json_encode($a);
    }elseif (isset($_POST['removeData'])) {
        $sql = "DELETE from `qualification_standards` where `id`='$_POST[removeData]'";
        $sql = $mysqli->query($sql);
        if(!$sql){
            $msg = "ERROR".$mysqli->error;
            $status = 'error';
            $sq = [];
        }else{
            $msg = "Data are removed permanently";
            $status = 'warning';
            $qs = qualification_standards();
        }
        $a =  array('msg' => $msg,'status' => $status ,'QS' => $qs);
        echo json_encode($a);
    }
    function qualification_standards(){
        $mysqli = $GLOBALS['mysqli'];
        $sql = "SELECT * from `qualification_standards`";
        $sql = $mysqli->query($sql);
        if (!$sql) {
            return $mysqli->error;
        }else{
            $a = [];
            while ($ar = $sql->fetch_assoc()) {
                $a[$ar['position_id']] = $ar;
            }
            return $a;
        }    
    }
?>