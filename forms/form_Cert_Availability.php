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
$pdf->SetAuthor('HRMO');
$pdf->SetTitle($file_title . 'Certificate of Availability of Funds');

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
$pdf->SetFont('helvetica', 'B', 11);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
// -----------------------------------------------------------------------------


$tbl = <<<EOD
                  <table><tr>
                        <td width="60%"> <img src="assets/images/forms/form_header.jpg" width="200px"></td>
                        <td width="40%">
                         <div style="float: right;text-align:right ">
                            <b>CITY MAYOR'S OFFICE</b><br>
                            New City Hall, Cabcabon, Banga<br>
                            Bayawan City,Negros Oriental, Philippines<br>
                            (035) 430 - 0281<br>
                            <u>www.bayawancity.gov.ph</u><br>
                        </div></td>
                      </tr>
                  </table>

                  <br><br><br><br><br><br><br><br>

               <p align="center"><u><b style="font-size:25px">C E R T I F I C A T I O N</u></b></p>
               <br><br><br><br><br><br><br><br>
               <br><br>
  </center> 
                    <p style="font-size:16px; text-align: justify; text-indent:30px" class="small"> In connection with the proposed appointment of <u>echoPASCUAL P. TOMULTO</u>  as <u>Programmer III</u>, at <u><b> echo P 15, 627.00</b></u> per month, in the office of the City Treasurer, Bayawan City, I hereby certify:
                    </p>

                    <p style="font-size:16px; text-align: justify; text-align-last: justify; text-indent: 50px" class="small"> a) That it is issued in accordance with the limitations provided for under Administrative Order No. 265 and Section 325 of R.A. No. 7160</u>.
                    </p>

                     <p style="font-size:16px; text-align: justify; text-align-last: justify; text-indent: 50px" class="small"> b) That her/his performance rating for January-June 2019 is Outstanding under our agency's approved SPMS.</u>.
                    </p>
                     <br>

                    <p style="font-size:16px; text-align: justify; text-indent:30px" >Issued this <u>18th</u> day of <u>May, 2020</u> in <u>Bayawan City</u></p>
                  
                    <br> <br> <br> 

                  <p style="font-size:16px"><center>
                  </p>

                  <table><tr>
                  <td width="60%"></td>
                  <td width="40%">
                  <b  style="font-size:16px">
                  &nbsp;&nbsp;&nbsp;<u>PYRDE HENRY A. TEVES</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>CITY MAYOR</cite>
                  </b></td>
                  </tr>
                  </table>

                  <br>
                  <br><br> <br>
                  <br>
                  <p align="center"><u><b style="font-size:25px">C E R T I F I C A T I O N</u></b></p>
                     <br><br>
                     <br><br>
                 </center> 

                  <p style="font-size:16px; text-align: justify; text-indent:30px" >I hereby certify that funds for the proposed position are available.</p>
                  
                  <br><br><br><br>

                 <p style="font-size:16px"><center>
                  </p>

                   <table><tr>
                    <td width="60%"></td>
                    <td width="40%">
                    <b  style="font-size:16px">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CORAZON P. LIRAZAN</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>CITY ACCOUNTANT</cite>
                    </b></td>
                    </tr>
                    </table>
<br><br><br>
                   <div>
                     <img src="assets/images/forms/form_footer.jpg" style= width="1000px">
                   </div>

 
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title . 'Certificate of Availability of Funds.pdf', 'I');

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
