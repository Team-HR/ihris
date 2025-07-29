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
$width=215.9;
$height=330.2;
$pageLayout = array($width, $height); //  or array($height, $width) 
// $pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$where ="";
$file_title ="";


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FranzDev');
$pdf->SetTitle($file_title.'Oath of Office');

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
$pdf->SetFont('helvetica', 'B', 11);

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
// -----------------------------------------------------------------------------


$tbl = <<<EOD
<div class="ui container" >
    <b style="font-size:15px;">CS Form No.32</b><br>
    <i>Revised 2017</i>

<br>
<br>
<br>

              <p align="center" style="font-size:17px"><b style="font-size:17px"> REPUBLIC OF THE PHILIPPINES<br></b>
                                            Province of Negros Oriental<br>
                                            City of Bayawan
              </p><br><br>
              
                <p></p>

               <p align="center"><b style="font-size:20px">OATH OF OFFICE</b></p>
               <br><br>
               <br><br>
  </center> 
                     <p style="font-size:16px; text-align: justify; text-indent:30px; line-height:2;"> I, <u><b>PASCUAL P. TOMULTO</b></u> of <u> BANGA, BAYAWAN CITY</u> having been appointed to the position of <u>Programmer III</u> hereby solemly swear, that I will faithfully discharge to the best of my ability, the duties of my present position and all of others that I may hereafter holf under the Republic of the Philippines; that I will bear true faith and allegiance to the same; that I will obey the laws,legal orders, and decrees promulgated by the duly constituted authorities of the Republic of the Philippines; and that I impose this obligation upon
                    </p>
                    <p style="font-size:16px; text-align: justify; text-indent:30px" >SO HELP ME GOD.</p>
                    <br>
                    <br> 

                    <p></p>
                  <table><tr>
                      <td width="60%"></td>
                      <td width="40%">
                      <b  style="font-size:16px">
                      &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>PASCUAL TOMULTO</u>&nbsp;&nbsp;&nbsp;&nbsp;<br> </b>
                      <cite> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  (Signature over Printed Name of the Appointee)</cite>
                     </td>
                      </tr>
                  </table>

                  <div style="clear:both "></div>


                  <p style="font-size:14px; text-align: justify;">
                      Government ID: <u><b> LGU ID</b></u><br>
                      ID NUmber: <u><b> 219***</b></u><br>
                      Date Issued: <u><b> 5/20/2070</b></u><br>
                  <p>

<br>
<br>
                  <p style="font-size:16px; text-align: justify; text-indent:30px; line-height:2"> Subscribed and sworn to before me this <u>1st</u> day of <u>May</u>, <u>2020</u> in <u>New City Hall, Cabcabon Hills, Barangay Banga, Bayawan City, Negros Oriental, Philippines</u></p>
<br>
<br>
                  <p></p>
                  <table><tr>
                      <td width="55%"></td>
                      <td width="45%">
                      <b  style="font-size:16px">
                      &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>PYRDE HENRY A. TEVES</u>&nbsp;&nbsp;&nbsp;&nbsp;<br> </b>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>City Mayor</cite>
                     </td>
                      </tr>
                  </table>

 </div>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Oath of Office.pdf', 'I');

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