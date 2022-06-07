<?php
    require_once "../../_connect.db.php";


    $page = $_POST['page'];
    if($page == 'POSITION'){
        $sql = "SELECT * from `positiontitles`";
        $sql = $mysqli->query($sql);
        $ar = [];
        while ($row = $sql->fetch_assoc()){
            $ar[] = $row;
        }
        echo json_encode($ar);
    }elseif($_POST['dutiesConfig']){
        $num = $_POST["num"];
        $workstatement = $mysqli->real_escape_string($_POST["workstatement"]);
        $percent = $_POST["percent"];
        $positionId = $_POST["dutiesConfig"];
        $editId = $_POST["editId"];
        if($editId){
            $sql = "UPDATE `statement_of_duties` 
                    SET `percentile` = '$percent', 
                        `no` = '$num', 
                        `workstatement` = '$workstatement' 
                    WHERE `statement_of_duties`.`statement_id` = $editId";
        }else{
            $sql = "INSERT INTO `statement_of_duties` 
                    (`statement_id`, `position_id`, `percentile`, `no`, `workstatement`) 
                    VALUES 
                    ('', '$positionId', '$percent', '$num', '$workstatement')";
        }
        $sql = $mysqli->query($sql);
        if(!$sql){
            echo $mysqli->error;
        }
        echo getDuties();
    }elseif($_POST['getDuties']){
        echo getDuties();
    }elseif(isset($_POST['deleteDuty'])){
        $rmove = $_POST['deleteDuty'];
        $sql = "DELETE FROM `statement_of_duties` WHERE `statement_of_duties`.`statement_id` = $rmove";
        $sql = $mysqli->query($sql);
        if(!$sql){
            echo $mysqli->error;
        }else{
            echo getDuties();
        }
    
    }

    function getDuties(){
        $mysqli = $GLOBALS['mysqli'];
        $positionId = $_POST['getDuties'] ?: $_POST["dutiesConfig"] ?: $_POST['positionId'];
        $sql = "SELECT * from `statement_of_duties` where position_id='$positionId' ORDER BY `statement_of_duties`.`no` ASC";
        $sql = $mysqli->query($sql);
        $ar = [];
        while($row = $sql->fetch_assoc()){
            $ar[] = $row;
        }
        return json_encode($ar);
    }
?>