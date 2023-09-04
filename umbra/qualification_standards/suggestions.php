<?php
    require_once "../../_connect.db.php";
    $find = $mysqli->real_escape_string($_POST['find']);
    $col = $mysqli->real_escape_string($_POST['col']);
    $sql = "SELECT * from `qualification_standards` where `$col` like '%$find%'";
    $sql = $mysqli->query($sql);
    $ar = [];
    while($dat = $sql->fetch_assoc()){
        $c = count($ar);
        if($c<=2){
            if($c==0){
                $ar[] = $dat[$col]; 
            }else{
                $i=0;
                while($i<=$c){
                    if($i==$c){
                        $ar[] = $dat[$col];
                    }elseif($ar[$i]==$dat[$col]){
                        break;
                    }
                    $i++;
                }
            }
        }else{
            break;
        }
    }
    echo json_encode($ar);


?>