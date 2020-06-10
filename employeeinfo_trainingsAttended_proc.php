<?php
require_once "_connect.db.php";

if (isset($_POST['getTrainingRows'])) {
    
    $employees_id = $_POST['employees_id'];
    $trainings_arr = createTrainings($mysqli, $employees_id, "all");

    $html = '';
    $num = 1;
    foreach ($trainings_arr as $training) {
        $html .= '<tr>';
            $html .= '<td>'.$num++.'</td>';

            if ($training['controlNumber']) {
                $link = '<a href="reqsandcoms.php?controlNumber='.$training['controlNumber'].'"><i class="icon external alternate"></i></a>';   
            } elseif ($training['personneltrainings_id']) {
                $link = '<a href="personneltrainingspreview.php?personneltrainings_id='.$training['personneltrainings_id'].'"><i class="icon external alternate"></i></a>';    
            }
            $html .= '<td>'.$link.'     '.$training['training'].'</td>';
            
            $numHours = $training['numHours'];
            $startDate = $training['startDate'];
            $endDate = $training['endDate'];

            $html .= '<td>'.($numHours === "8" ? date("F d, Y", strtotime($startDate)):date("F d", strtotime($startDate))." - ".date("d, Y", strtotime($endDate))).'</td>';
            $html .= '<td>'.$training['numHours'].'</td>';
            $html .= '<td>'.$training['venue'].'</td>';
            $html .= '</tr>';
    }
            $html .= spms_feedBacking($num);
    echo json_encode($html);
    // echo json_encode(var_dump($_POST['getRows']));
} elseif (isset($_POST['addTraining'])) {

    $employees_id = $_POST['employees_id'];
    echo json_encode($employees_id);

}

/*******
 * 
 * @author Pascual Tomulto
 * @description 
     -- spms feedbacking
*/
    function spms_feedBacking($count){
        $mysqli = $GLOBALS['mysqli'];
        $html = "";
        $sql = "SELECT * from `spms_feedbacking` where `feedbacking_emp`='$_POST[employees_id]'";
        $sql = $mysqli->query($sql);

        while($details = $sql->fetch_assoc()){
            $html .= "<tr>
                        <td>$count</td>
                        <td><a href='umbra/feedback/pdf.php?reference=$_POST[employees_id]&feedBackYR=$details[feedbacking_year]' target='_blank    '><i class='icon external alternate'></i></a>Feedback Monitoring</td>
                        <td>".date('F j, Y',strtotime($details['date_conducted']))."</td>
                        <td>N/A</td>
                        <td>N/A</td>
                    </tr>";
            $count++;
        }
        return $html;
    }

    function 



/***************
 * 
 * end of pascual code
 * 
 */



function getNumHours($date_early,$date_late)
{
    $date1 = strtotime($date_early);
    $date2 = strtotime($date_late);
    $dateDiff = $date2 - $date1;
    $numHrs = (($dateDiff/ (60 * 60 * 24))*8)+8;
    return $numHrs;
}

function createTrainings($mysqli,$employees_id,$year)
{

  if ($year !== "all") {
    $filterByYear  = "AND year(personneltrainings.startDate) = '$year'";
    $filterByYear2  = "AND year(`requestandcoms`.`fromDate`) = '$year'";
  } else {
    $filterByYear = "";
    $filterByYear2 = "";
  }


    $arrMaster = array();
    
    $sql1 = "SELECT * FROM `personneltrainingslist`
        LEFT JOIN personneltrainings
            ON personneltrainingslist.personneltrainings_id = personneltrainings.personneltrainings_id
        LEFT JOIN trainings
            ON personneltrainings.training_id = trainings.training_id
        WHERE `personneltrainingslist`.`employees_id` = '$employees_id' $filterByYear";

    $result1 = $mysqli->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $personneltrainings_id = $row1["personneltrainings_id"];
        $training = $row1["training"];
        $startDate = $row1["startDate"];
        $endDate = $row1["endDate"];
        $numHours = $row1["numHours"];
        $remarks = $row1["remarks"];
        $venue = $row1["venue"];

        $insertArr = array(
            'controlNumber' => null,
            'personneltrainings_id' => $personneltrainings_id,
            'training' => $training,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'numHours' => $numHours,
            'remarks' => $remarks,
            'venue' => $venue
        );

        array_push($arrMaster, $insertArr);
    }


    $sql2 = "SELECT * FROM `requestandcoms`
    LEFT JOIN `requestandcomslist`
        ON `requestandcoms`.`controlNumber` = `requestandcomslist`.`controlNumber`
        WHERE `requestandcomslist`.`employees_id` = '$employees_id' AND `requestandcoms`.`isMeeting` != 'yes' $filterByYear2";
    $result2 = $mysqli->query($sql2);
    while ($row2 = $result2->fetch_assoc()) {
        $controlNumber = $row2["controlNumber"];
        $training = $row2["subject"];
        $startDate = $row2["fromDate"];
        $endDate = $row2["toDate"];
        $numHours = getNumHours($startDate,$endDate);
        $remarks = $row2["remarks"];
        $venue = $row2["venue"];
        $insertArr = array(
            'controlNumber' => $controlNumber,
            'personneltrainings_id' => null,
            'training' => $training,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'numHours' => $numHours,
            'remarks' => $remarks,
            'venue' => $venue
        );

        array_push($arrMaster, $insertArr);
    } 
        usort($arrMaster, function($a, $b) {
            return $b['startDate'] <=> $a['startDate'];
        });
        
    return $arrMaster;
}

function dateToStr1($numeric_date){
    if ($numeric_date) {
      $date = new DateTime($numeric_date);
      $strDate = $date->format('F d, Y');
    } else {
      $strDate = "<i style=\"color:grey\">N/A</i>";
    }
      
    return $strDate;
}


?>