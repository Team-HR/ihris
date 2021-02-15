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

// create new PDF document
$width=210;
$height= 297;
$pageLayout = array($width, $height); //  or array($height, $width) 
// $pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);

}

  $employee_id ='{"dtrSummary_id":"3","employee_id":"2","month":"2021-01","totalMinsTardy":"749","totalTardy":"11","totalMinsUndertime":"480","letterOfNotice":"0","halfDaysTardy":"02,03","halfDaysUndertime":"02,03","remarks":"01-ABSENT,04-ABSENT,05-WFH(DUE%20TO%20EXPOSURE)","submitted":"0","employees_id":"2","firstName":"ERIC","lastName":"BABOR","middleName":"M.","extName":"","gender":"MALE","status":"INACTIVE","employmentStatus":"CASUAL","department_id":"16","position_id":"200","natureOfAssignment":"RANK%20&%20FILE","dateActivated":"0000-00-00","dateInactivated":"0000-00-00","dateIPCR":"0000-00-00","department":"SP%20AND%20CITY%20VICE%20MAYOR%27S%20OFFICE","position":"ADMINISTRATIVE%20AIDE%20I%20","functional":"CASUAL","level":"1","category":"Administrative","salaryGrade":"1"}';
// $employee_id = addcslashes($_GET['selectedDat']);
// $asd = json_decode($employee_id,true);

// var_dump($asd);

$emp = json_encode($_GET['selectedDat']);
$emp = str_replace("\\", ' ', $emp);
$asd = json_decode($emp,true);

echo $_GET['selectedDat'];
// var_dump($emp); 

echo "<br>";
// echo $employee_id;
  


// ---------------------------------------------------------
$where ="";
$file_title ="";


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HRMO');
$pdf->SetTitle($file_title.'Letter of Notice [Tardiness]');
require_once('_connect.db.php');

// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('helvetica', 'B', 10);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
$year = date('Y');


require_once "_connect.db.php";





// -----------------------------------------------------------------------------
$tbl = <<<EOD
                  <table><tr>
                        <td width="60%"> <img src="form_header.png" width="200px"></td>
                        <td width="40%">
                         <div style="float: right;text-align:right ">
                            <b>CITY HUMAN RESOURCE MANAGEMENT OFFICE</b><br>
                            New City Hall, Cabcabon, Banga<br>
                            Bayawan City,Negros Oriental, Philippines<br>
                            Fax No.: 430 0222
                            <br>
                            (035) 430 - 0263<br>
                            <u>email : vgpmiraflor@gmail.com</u><br>
                        </div></td>
                      </tr>
                  </table>

                  <br><br><br>
                  
                <p  style="font-size: 12.5px; text-align: justify;  text-indent: -2em; line-height: 1.3">
                    MEMORANDUM NO._______________<br><br>

                    <br><br><br>
                    TO:	    Name of Employee <br>
                            Position <br><br>
                    RE	:	  <i>Habitual Tardiness</i>
                 <br><br><br>

                    This is to inform that per your DTR submitted to the Human Resource Management Office, you have incurred more than 10 times tardy for the month <b>$</b>.
                    <br>
                    <br>
                    Please be reminded that Section 8, Rule XVIII of the Omnibus Rules Implementing Title I, Subtitle A, Book V of the Administrative Code of 1987, as amended, provides that:
                    <br><br>
                   <i>  
                      “SEC. 8. Officers and employees who have incurred tardiness and undertime, regardless of the number of minutes per day, ten (10) times a month for at least two (2) consecutive months during the year or at least two (2) months in a semester shall be subject to disciplinary action.”
                   </i>   

                      <br><br>
                    Section 52, Rule VI of Civil Service Circular No. 19, Series of 1999, on the Revised Uniform Rules on Administrative Cases in the Civil Service, provides:
                        <br><br>
                    Frequent unauthorized tardiness (Habitual Tardiness)<br><br>
                    1st Offense	-	Reprimand<br>
                    2nd Offense	-	Suspension 1-30 days<br>
                    3rd Offense	-	Dismissal<br>

                    
                    <br><br>
                    Hence, this memorandum serves as a stern warning that we will be compelled to impose above penalties should you continue to violate this policy.
                    <br><br>
                    Be guided accordingly.
                    <br> <br>
                    <br> <br>
                  
                    <b>VERONICA GRACE P. MIRAFLOR</b><br>
                    CGDH I <br><br>
                    Received by: _______________________<br>
                    Date Received: _____________________
                    </p>
                
               <br><br>
  </center> 
                  
<br><br><br>
                   <div>
                     <img src="form_footer.png" style= width="1000px">
                   </div>

 
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Letter of Notice [Tardiness]', 'I');

//============================================================+
// END OF FILE
//============================================================+
function lister($arr){
  $item ="";
  if (isset($arr)) {
    foreach ($arr as $key => $value) {
      $item .= " *".$value;
    }
  } else {
    $item ="*None Required";
  }
  
  return $item;

}