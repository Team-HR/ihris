<?php
//============================================================
// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf_import.php');
require_once('_connect.db.php');
require 'libs/Department.php';
$deparment = new Department();

  $rspvac_id = $_GET["rspvac_id"];

  $sql = "SELECT * FROM `rsp_vacant_positions` WHERE `rspvac_id` = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$rspvac_id);
  $stmt->execute();
  // $stmt->store_result(); 
  $stmt->bind_result($rspvac_id,$position, $itemNo, $sg,$office,$dateVacated,$dateOfInterview,$education,$training,$experience,$eligibility,$datetime_added);
  $stmt->fetch();
        if (!$itemNo) {
          $itemNo = "---";
        } else {
          $itemNo = $itemNo;
        }
  $data = array(
    "rspvac_id" => $rspvac_id,
    "position" => $position,
    "itemNo" => $itemNo,
    "sg" => $sg,
    "office" => $office,
    "dateVacated" => $dateVacated,
    "education" => unserialize($education),
    "training" => unserialize($training),
    "experience" => unserialize($experience),
    "eligibility" => unserialize($eligibility)
  );
  $stmt->close();

  $sql = "SELECT `rspcomp_id`, `rsp_comparative`.`applicant_id`, `name`,`age`,`gender`,`num_years_in_gov`,`civil_status`,`education`,`school`,`training`,`experience`,`eligibility`,`awards`,`records_infractions` FROM `rsp_applicants` LEFT JOIN `rsp_comparative`ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rspvac_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$rspvac_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result(
      $rspcomp_id,
      $applicant_id,
      $name,
      $age,
      $gender,
      $num_years_in_gov,
      $civil_status,
      $education,
      $school,
      $training,
      $experience,
      $eligibility,
      $awards,
      $records_infractions
    );
$applicants_table = "";
$counter = 0;
while ($stmt->fetch()) {
  $counter++;
  $yrsgov = createYosList($num_years_in_gov);
  $tr = createList(unserialize($training));
  $exp = createList(unserialize($experience),false);
  $elig = createList(unserialize($eligibility));
  $awards = createList(unserialize($awards));
  $rec_inf = createList(unserialize($records_infractions));
  // $applicants_table .= "<br>";
  $applicants_table .= <<<EOD
<hr>
<table border="" cellspacing="">
  <tr>
    <td colspan="6"></td>
  </tr>
  <tr nobr="true" bgcolor="#e5f2ff">
    <td width="9%"><b>Applicant #$counter:</b></td>
    <td width="20%">$name</td>
    <td width="5%"><b>Age:</b> $age</td>
    <td width="9%"><b>Gender:</b> $gender</td>
    <td width="12%"><b>Civil Status:</b> $civil_status</td>
    <td width="45%"><b>Years in Government Service:</b> $yrsgov</td>
  </tr>
  <tr>
    <td><b>Education:</b></td>
    <td colspan="5">$education in $school</td>
  </tr>
  <tr>
    <td><b>Training:</b></td>
    <td colspan="5">$tr</td>
  </tr>
  <tr>
    <td><b>Experience:</b></td>
    <td colspan="5">$exp</td>
  </tr>
  <tr>
    <td><b>Eligibility:</b></td>
    <td colspan="5">$elig</td>
  </tr>
  <tr>
    <td><b>Awards:</b></td>
    <td colspan="5">$awards</td>
  </tr>
  <tr>
    <td width="13%"><b>Records of Infractions:</b></td>
    <td colspan="5">$rec_inf</td>
  </tr>
  <tr>
    <td colspan="6"></td>
  </tr>
</table>
EOD;

  }

// create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$tab_title = $pdf->SetTitle($position." ".$dateVacated);
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'RSP - Comparative Data '.date('Y',strtotime($dateVacated)), PDF_HEADER_STRING."\nprinted ".date('F d, Y - h:i:s A'));

// set header and footer fonts
$pdf->setHeaderFont(Array('times', 'I', 9));
$pdf->setFooterFont(Array('times','',9));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 21, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('helvetica', 'I', 20);
// add a page
$pdf->AddPage();
// $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
$pdf->SetFont('times', '', 9);

// ------------------------------------------------------------------------------
$pageWidth = $pdf->getPageWidth();
$dept = $deparment->getDepartment($office);
$education_list = listdis($data[education]);
$training_list = listdis($data[training]);
$experience_list = listdis($data[experience]);
$eligibility_list = listdis($data[eligibility]);

$tbl = <<< EOD
    <table border="" cellpadding="" cellspacing="" >
      <tr>
        <td width="12%"><b>VACANT POSITION:</b></td>
        <td width="38%">$position</td>
        <td width="9%"><b>CSC ITEM NO:</b></td>
        <td width="11%">$itemNo</td>
        <td width="5%"><b>OFFICE:</b></td>
        <td width="25%">$dept</td>
      </tr>
      <tr>
        <td><b>EDUCATION:</b></td>
        <td colspan="5">$education_list</td>
      </tr>
      <tr>
        <td><b>EXPERIENCE:</b></td>
        <td colspan="5">$experience_list</td>
      </tr>
      <tr>
        <td><b>TRAINING:</b></td>
        <td colspan="5">$training_list</td>
      </tr>
      <tr>
        <td><b>ELIGIBILITY:</b></td>
        <td colspan="5">$eligibility_list</td>
      </tr> 
    </table>
    <table border="0">
    <tr style="line-height: 40%;" > 
    <td></td>
    </tr>
    </table>
    $applicants_table
EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------

//Close and output PDF document
$filename = $position." ".$dateVacated.".pdf";
$pdf->Output($filename, 'I');

//============================================================+
// END OF FILE
//============================================================+

function listdis($arr){
  $list = "";
  foreach ($arr as $key => $value) {
    $list .= $value;
    if (count($arr) != $key+1) {
      $list .= "; &nbsp;&nbsp;";
    }
  }
  return $list;
}



function createList($arr,$bool = true){
  $list = "";
  if ($arr) {
    if ($bool) {
      foreach ($arr as $key => $value) {
        $list .= "[".($key+1).".] $value ";
      }
    } else {
      foreach ($arr as $key => $value) {
        $dates = "";
        if (!$value[3] && !$value[4]) {
          $dates = "(Dates not indicated)";
        } elseif (!$value[3] && $value[4]) {
          $dates = "(To: ".formatDate($value[4]).")";
        } elseif ($value[3] && !$value[4]) {
          $dates = "(From: ".formatDate($value[3])." to Present)";
        } else {
          $dates = "(".formatDate($value[3]) ." - ".formatDate($value[4]).")";
        }
        $list .= "[".($key+1).".] $value[2] <i>as</i>  <span style=\"color:#025214; font-weight: bold;\">$value[0]</span> $dates ";

      }
    }
  } else {
    $list .= "[1.] NONE";
  }
  return $list;
} 

function createYosList($serial){
  
  $arr = unserialize($serial);

  $list = "";
  $counter = 0;
  foreach ($arr as $index => $value) {
    $i = 1;
    if ($value) {
      $list .= "[".$i++.".] ".$index.": $value ";
    } else {
      $counter++;
    }
  }
  if ($counter === count($arr)) {
    $list = "[1.] NONE";
  } 
  return $list;
}


function formatDate($numeric_date)
{
    $date = new DateTime($numeric_date);
    $strDate = $date->format('M d, Y');
    return $strDate;
}


