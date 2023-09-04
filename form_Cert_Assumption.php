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
$pdf->SetTitle($file_title.'Certificate of Assumption to Duty');

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
  <div class="ui container">
    <b style="font-size:14px;">CS Form No.4<br>
    Series of 2017</b>

<br><br><br>
              <p align="center"><b style="font-size:16px"> REPUBLIC OF THE PHILIPPINES<br>
                                Province of Negros Oriental<br>
                                <u>City of Bayawan</u></b></p>
                                <br><br><br><br><br>
            
               <p></p><br><br><br>
               <p align="center" style="font-size:20px"><b>CERTIFICATION OF ASSUMPTION TO DUTY</b>
               </p>
               <br><br><br><br><br><br>
               

                    <p style="font-size:16px; text-align: justify; text-indent:30px" class="small"> This is to certify that <u>PASCUAL P. TOMULTO</u> has assumed the duties and responsibilities as <u>Programmer III</u> of <u>Human Resource Management Office</u> effective <u> May 15, 2070</u>
                    </p>

                    <p style="font-size:16px; text-align: justify; text-indent:30px" class="small"> This certification is issued in connection with the issuance of the appointment of <u>Pascual P. Tomulto</u> as <u>Programmer III</u>.
                    </p>
                    <p style="font-size:16px; text-align: justify; text-indent:30px" >Done this <u>15th</u> day of <u>May, 2020</u> in <u>Bayawan City</u>.</p>
                    <br><br><br><br>

                  <p></p>
                  <table><tr>
                      <td width="60%"></td>
                      <td width="50%">
                      <b  style="font-size:16px">
                      &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>PYRDE HENRY A. TEVES</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Head of Office/Department/Unit</cite>
                      </b></td>
                      </tr>
                  </table>



                      <br><br><br><br><br><br><br><br>  
                    
                  <p style="font-size:16px; text-align: justify; text-indent:30px" class="small">Date:<u><b>echo May 15, 2070</b></u></p>
                  <p style="font-size:16px; text-align: justify; text-indent:30px" class="small">Attested by:</u></p>
                        <br><br><br><br>
                    <p></p> <p></p>       
                  <div style="float:left;text-align: justify;font-size:16px;text-indent:30px"><center><u><b> VERONICA GRACE P. MIRAFLOR</u></b><br>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HRMO IV</center>
                  </div>

  <br><br><br><br><br><br> 
   <p></p> <p></p>     
  <i style="font-size:15px;">
  201 file<br>
  Admin<br>
  COA<br>
  CSC</i>


 </div>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Certificate of Assumption to Duty.pdf', 'I');

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