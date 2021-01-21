<?php
//============================================================+
// File name   : example_048.php
// Begin       : 2009-03-20
// Last Update : 2013-05-14
//
// Description : Example 048 for TCPDF class
//               HTML tables and table headers
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: HTML tables and table headers
 * @author Nicola Asuni
 * @since 2009-03-20
 */

// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf.php');
require_once('_connect.db.php');
require "libs/NameFormatter.php";
require "libs/NumberToWords.php";

$appointment_id = $_GET["appointment_id"];

$sql = "SELECT * FROM `appointments` 
LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` 
LEFT JOIN `plantillas` ON `appointments`.`plantilla_id` = `plantillas`.`id`
LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id`
WHERE `appointments`.`appointment_id` = '$appointment_id'";
$result = $mysqli->query($sql);

$appointment = $result->fetch_assoc();
$salary_sql = "SELECT
                        setup_salary_adjustments_setup.monthly_salary
                    FROM
                        setup_salary_adjustments_setup
                        LEFT JOIN
                        setup_salary_adjustments
                        ON 
                            setup_salary_adjustments_setup.parent_id = setup_salary_adjustments.id
                    WHERE
                        setup_salary_adjustments.`schedule` = $appointment[schedule] AND
                        setup_salary_adjustments_setup.step_no = $appointment[step] AND
                        setup_salary_adjustments_setup.salary_grade = $appointment[salaryGrade] AND
                        setup_salary_adjustments.active = 1";

$res = $mysqli->query($salary_sql);
$salary_data = $res->fetch_assoc();
$appointment["monthly_salary"] = $salary_data["monthly_salary"];
$monthly_salary = $appointment["monthly_salary"];
$name_formatter = new NameFormatter($appointment["firstName"], $appointment["lastName"], $appointment["middleName"], $appointment["extName"]);
$full_name = $name_formatter->getFullNameStandardTitle();
$appointment_id = $appointment["appointment_id"];
$employee_id = $appointment["employee_id"];
$plantilla_id = $appointment["plantilla_id"];
$reason_of_vacancy = $appointment["reason_of_vacancy"] ? $appointment["reason_of_vacancy"] : blank();
$office_assignment = $appointment["office_assignment"];
$probationary_period = $appointment["probationary_period"];
$status_of_appointment = $appointment["status_of_appointment"];
$date_of_appointment = $appointment["date_of_appointment"];
$date_of_assumption = $appointment["date_of_assumption"];
$nature_of_appointment = $appointment["nature_of_appointment"];
$nature_of_appointment = formatToTitleCase($nature_of_appointment);
$appointing_authority = $appointment["appointing_authority"];
$date_of_signing = $appointment["date_of_signing"];
$date_of_signing = $date_of_signing !== '0000-00-00' ? dateToString($date_of_signing) : blank();
$csc_authorized_official = $appointment["csc_authorized_official"];
$csc_mc_no = $appointment["csc_mc_no"];
$csc_mc_no = $csc_mc_no ? $csc_mc_no : blank();
$series_no = $appointment["series_no"];
$series_no = $series_no ? $series_no : blank();
$assesment_date_from = $appointment["assesment_date_from"];
$assesment_date_to = $appointment["assesment_date_to"];
$deliberation_date_from = $appointment["deliberation_date_from"];
$deliberation_date_from = $deliberation_date_from !== '0000-00-00' ? dateToString($deliberation_date_from) : blank();
$deliberation_date_to = $appointment["deliberation_date_to"];
$date_signed_by_csc = $appointment["date_signed_by_csc"];
$committee_chair = $appointment["committee_chair"];
$HRMO = $appointment["HRMO"];
$cert_fund_available = $appointment["cert_fund_available"];
$published_at = $appointment["published_at"];
$published_at = $published_at ? dateToString($published_at) : blank();
$posted_in = $appointment["posted_in"];
$posted_in = $posted_in ? $posted_in : "BVP and 3 conspicuous places";
$posted_date_from = $appointment["posted_date_from"];
$posted_date_from = $posted_date_from !== '0000-00-00' ? dateToString($posted_date_from) : blank();
$posted_date_to = $appointment["posted_date_to"];
$posted_date_to = $posted_date_to !== '0000-00-00' ? dateToString($posted_date_to) : blank();
$csc_release_date = $appointment["csc_release_date"];
$govId_type = $appointment["govId_type"];
$govId_no = $appointment["govId_no"];
$govId_issued_date = $appointment["govId_issued_date"];
$sworn_date = $appointment["sworn_date"];
$cert_issued_date = $appointment["cert_issued_date"];
$last_day_of_service = $appointment["last_day_of_service"];
$supervisor = $appointment["supervisor"];
$casual_promotion = $appointment["casual_promotion"];
$predecessor = $appointment["predecessor"];
$date_of_last_promotion = $appointment["date_of_last_promotion"];
$employees_id = $appointment["employees_id"];
$firstName = $appointment["firstName"];
$lastName = $appointment["lastName"];
$middleName = $appointment["middleName"];
$extName = $appointment["extName"];
$gender = $appointment["gender"];
$status = $appointment["status"];
$employmentStatus = $appointment["employmentStatus"];
$employmentStatus = formatToTitleCase($employmentStatus);
$department_id = $appointment["department_id"];
$position_id = $appointment["position_id"];
$natureOfAssignment = $appointment["natureOfAssignment"];
$dateActivated = $appointment["dateActivated"];
$dateInactivated = $appointment["dateInactivated"];
$dateIPCR = $appointment["dateIPCR"];
$id = $appointment["id"];
$item_no = $appointment["item_no"];
$department_id = $appointment["department_id"];
$position_id = $appointment["position_id"];
$step = $appointment["step"];
$schedule = $appointment["schedule"];
$incumbent = $appointment["incumbent"];
$vacated_by = $appointment["vacated_by"];


//######################## get name of signatories start

// city mayor
if ($appointing_authority) {
  $sql = "SELECT * FROM `signatory_saves` WHERE `id`='$appointing_authority'";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $city_mayor = $row["name"];
  } else 
  $city_mayor = blank();
} 

// hrmo
if ($HRMO) {
  $sql = "SELECT * FROM `signatory_saves` WHERE `id`='$HRMO'";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $hrmo_personnel = $row["name"];
  $hrmo_position = $row["position"];
  } else {
    $hrmo_personnel = blank();
    $hrmo_position = blank();
  }
  
}
// committee chairperson
if ($committee_chair) {
  $sql = "SELECT * FROM `signatory_saves` WHERE `id`='$committee_chair'";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $hrmpsb_chair = $row["name"];
  } else $hrmpsb_chair = blank();
  
}
//######################## get name of signatories end

//######################## get name of incumbent start
if ($vacated_by) {
  $sql_vacator = "SELECT `firstName`, `lastName`, `middleName`, `extName` FROM `employees` WHERE `employees_id` = '$vacated_by'";
  $res_vacator = $mysqli->query($sql_vacator);
  $vacator = $res_vacator->fetch_assoc();
  $name_formatter = new NameFormatter($vacator["firstName"], $vacator["lastName"], $vacator["middleName"], $vacator["extName"]);
  $vacated_by = $name_formatter->getFullNameStandardTitle();
} else {
  $vacated_by = blank();
}
//######################## get name of incumbent end

$abolish = $appointment["abolish"];
$department_id = $appointment["department_id"];
$department = $appointment["department"];
$department = formatToTitleCase($department);
$position_id = $appointment["position_id"];
$position = $appointment["position"];
$position = formatToTitleCase($position);
$functional = $appointment["functional"];
$level = $appointment["level"];
$category = $appointment["category"];
$salaryGrade = $appointment["salaryGrade"];

$numberToWords = new NumberToWords();
// $monthly_salary = 1231211;
$monthly_salary_in_words = $numberToWords->convert_number_to_words($monthly_salary);
$monthly_salary_formatted = number_format($monthly_salary, 2, '.', ',');
// $monthly_salary_in_words = "TYES";

// /////////////////////////////////////////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////
// create new PDF document





$width = 215.9;
$height = 330.2;
$pageLayout = array($width, $height); //  or array($height, $width) 
// $pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$where = "";
$file_title = "";


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FranzDev');
$pdf->SetTitle($file_title . 'CS FORM NO. 33-B');

// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);
// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// $pdf->SetFooterMargin(1);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 1);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('helvetica', 'B', 11);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
// -----------------------------------------------------------------------------


$tbl = <<<EOD

  <table cellspacing="0" cellpadding="2" >
        <tr>
            <td width="70%" colspan="2"></td>
            <td width="30%" border="1" align="center"><i><b>For Accredited/Deregulated Agencies</b></i></td>
        </tr>
   </table>
    <br><br>

  <div style="border:20px solid gray;"> 
    <table cellspacing="0" cellpadding="10" >
        <tr>
            <td width="60%"><b style="font-size:15px;font-family:Arial">CS Form No.33 - B</b> <br>  <i style="font-family:Arial">Revised 2018</i></td>
            <td width="40%" align="center"><i>(Stamp of Date of Receipt)</i></td>
        </tr>
    </table>
       <p align="center"  style="font-size:16px;"><b style="font-size:16px;"> REPUBLIC OF THE PHILIPPINES</b><br>
                                          Province of Negros Oriental<br>
                                          City of Bayawan
            </p><br><br>
    

            <p style="font-size:15px; text-align: justify; text-indent:15px"> 
                                         Mr./Ms./Mrs. <b><u>$full_name</u></b>
            </p>   

            <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3"> 
                                      You are hereby appointed as <b><u>$position</u></b> <u><b>(SG $salaryGrade, Step $step)</u></b> under <b><u>$employmentStatus</u></b> status at the <b><u> $department, LGU Bayawan City</u></b> with a comepensation rate of <b><u>$monthly_salary_in_words</u></b> <b><u>(P $monthly_salary_formatted)</u></b> pesos per month.
            </p>

            <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3" class="small"> 
                                       The nature of this appointment is <b><u>$nature_of_appointment</u></b> vice <b><u>$vacated_by</u></b> , who <b><u>$reason_of_vacancy</u></b> with Plantilla Item No. <b><u>$item_no</u></b> Page ____.</p>

                      <p style="font-size:14px; text-align: justify; text-indent:30px" class="small"> 
                        <b> This appointmet shall take effect on the date of signiing by the appointing officer/authority.</b>
                     </p>
      
<br>                
                     
                  <p></p>
                  <table><tr>
                      <td width="60%"></td>
                      <td width="50%">
                      <b  style="font-size:16px">
                      &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Very truly yours,&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      </b></td>
                      </tr>

                      <br><br><br>

                      <tr>
                      <td width="50%"></td>
                      <td width="50%">
                        <b  style="font-size:15px";align="center">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <u>$city_mayor</u>
                          &nbsp;&nbsp;&nbsp;&nbsp;<br> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <cite>City Mayor</cite></b>

                          <br><br><br>
                          <b  style="font-size:15px";align="center"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <u>$date_of_signing</u>
                          &nbsp;&nbsp;&nbsp;&nbsp;<br> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <cite>Date of Signing</cite></b>
                      </td>
                      </tr>
                  </table>

                    <br><br><br>
                     <p style="font-size:12px; text-align: justify;"> 
                        <b> Accredited/Deregulated Pursuant to <br>
                          CSC Resolution NO.1201478<br>
                          <u>September 26, 2012</u>
                        </b>
                     </p>

                     <table><tr>
                        <td width="80%" > 
                           <img src="csc logo.png" style="width:150px; margin-left:20px">
                        </td>
                        <td width="20%" > 
                          <br><br><br><br><br><br><br><br><br><br><br><br>
                          <i>(Stamp of Date of Release)</i>
                        </td>
                      </tr>
                  </table>
</div>
 <br><br><br><br>

<div style="border:20px solid gray;"> 
      <table cellspacing="0" cellpadding="10" >
            <tr>
                <td width="100%" style="font-size:18px" align="center"><b>Certification</b></td>
            </tr>

             <tr>
                <td width="100%" style="font-size:15px; line-height:1.5" align="justify">
                      This is to certify that all requirements ans supporting papers pursuant to CSC MC.No.<u><b>$csc_mc_no</b></u>, series of <u><b>$series_no</b></u> 
                     have been complied with, reviewed and found to be in order.
                     <br>  <br>
                     The position was published at <u><b>$published_at</b></u>  on <u><b>$posted_date_from</b></u> to <u><b>$posted_date_to</b></u> and posted
                       in <u><b>$posted_in</b></u> from <u><b>$posted_date_from</b></u> to <u><b>$posted_date_to</b></u> in consonance with <u><b>RA No. 7041</b></u>. The assessment by the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on</b> <u><b>$posted_date_from - 
                       $posted_date_to</b></u>.
                </td>
            </tr>
            <br>
            <tr>
                <td width="45%" style="font-size:18px" align="center"></td>
                <td width="55%">
                            <b  style="font-size:15px">
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>$hrmo_personnel</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>$hrmo_position</cite>
                </b></td>
            </tr>
       </table>
</div>
<div style="border:20px solid gray;"> 
      <table cellspacing="0" cellpadding="10" >
            <tr>
                <td width="100%" style="font-size:18px" align="center"><b>Certification</b></td>
            </tr>

             <tr>
                <td width="100%" style="font-size:15px; line-height:1.5" align="justify">
                    This is to certify that the appointee has been screened and found qualified by the majority of the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on</b> during the deliberation held on <u><b>$deliberation_date_from</b></u>.
                </td>
            </tr>
            <br>
            <tr>
                <td width="45%" style="font-size:18px" align="center"></td>
                <td width="55%">
                            <b  style="font-size:15px">
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>$hrmpsb_chair</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Chairperson, HRMPSB</cite>
                </b></td>
            </tr>
       </table>
</div>
 <br><br><br>
  <table cellspacing="0" >
            <tr>
                <td width="100%" style="font-size:15px" align="center"><b>CSC/HRMO Notation</b></td>
            </tr>
       </table>
 <div style="border:20px solid gray;">
 <br>
      <table cellspacing="0" cellpadding="10" background="gray" border="1" style="font-size:13px">
            <tr>
                <td width="80%" align="center"> ACTION ON APPOINTMENTS
                </td>
                <td width="19%" align="center"> Recorded by
                </td>
            </tr>
            <tr>
                <td width="80%">Validate per RAI for the month of _________________________________
                </td>
                <td width="19%" align="center"> 
                </td>
            </tr>
            <tr>
                <td width="80%">Invalidate per CSCRO/FO letter dated_________________________________
                </td>
                <td width="19%" align="center"> 
                </td>
            </tr>
              <tr>
                <td width="30%">Appeal
                </td>
                 <td width="30%" align="center">DATE FILED
                </td>
                 <td width="20%" align="center">STATUS
                </td>
                <td width="19%"> 
                </td>
            </tr>
             <tr>
                <td width="30%">CSCRO/CSC-Commission
                </td>
                 <td width="30%" align="center">
                </td>
                 <td width="20%" align="center">
                </td>
                <td width="19%"> 
                </td>
            </tr>
             <tr>
                <td width="30%">Petition for Review
                </td>
                 <td width="30%" align="center">
                </td>
                 <td width="20%" align="center">
                </td>
                <td width="19%"> 
                </td>
            </tr>
             <tr>
                <td width="30%">CSC-Commission
                </td>
                 <td width="30%" align="center">
                </td>
                 <td width="20%" align="center">
                </td>
                <td width="19%"> 
                </td>
            </tr>
             <tr>
                <td width="30%">Court of Appeals
                </td>
                 <td width="30%" align="center">
                </td>
                 <td width="20%" align="center">
                </td>
                <td width="19%"> 
                </td>
            </tr>
             <tr>
                <td width="30%">Supreme Court
                </td>
                 <td width="30%" align="center">
                </td>
                 <td width="20%" align="center">
                </td>
                <td width="19%"> 
                </td>
            </tr>

       </table>
  </div>
 <br><br><br>
  <div style="border:20px solid gray;">
 <br>
      <table cellspacing="0" background="gray" border="1" style="font-size:13px">
            <tr>
                <td width="40%" style="font-size: 10px" > 
                    Origin Copy - for the Appointee<br>
                    Origin Copy - for the Civil Service Commission<br>
                    Origin Copy - for the Agency<br>
                </td>
                <td width="59%" align="center" style="font-size: 12px" > 
                 <b>Acknowledgement</b><br><brs>
                    <i> Received original photocopy of appointment on <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></i><br>
                    <br>
                    <b><u>$full_name</u></b><br>
                    Appointee
                </td>
            </tr>
       </table>
  </div>
</div>

EOD;


// echo $tbl;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title . 'Certificate Form No. 33.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+



function lister($arr)
{
  $item = "";
  if (isset($arr)) {
    foreach ($arr as $key => $value) {
      $item .= " *" . $value;
    }
  } else {
    $item = "*None Required";
  }

  return $item;
}

function dateToString($date)
{
  if (!$date) return false;
  $date = date_create($date);
  return date_format($date, 'F d,Y');
}

function formatToTitleCase($str)
{
  if (!$str) return false;
  return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
}

function blank()
{
  return "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
