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

// ---------------------------------------------------------
$where ="";
$file_title ="";


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HRMO');
$pdf->SetTitle($file_title.'Letter of Notice [Reprimand]');

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
                     $dateOfUse 
                 

                    <br><br><br>
                    TO:	    Name of Employee <br>
                            Position <br><br>
                    RE	:	 <i>Habitual Tardiness</i>
                 <br><br>

                    Based on the Daily Time Record submitted to the Human Resource Management Office, you have incurred more than ten (10) times tardy on the following months: 
                   <br><br>

                        July 2020 - 11 times     <br>
                        August 2020 -12 times    <br>
                    <br>
                    Please be reminded that you were also reprimanded of your habitual tardiness last December 5, 2020 for incurring tardiness on July 2018 (14 times) and on October 2018 (10 times).
                    <br><br>
                    Please be informed that under Civil Service Memorandum Circular No. 23, s. 1998, <i>“Any employee shall be considered habitually tardy if he incurs 
                    tardiness, regardless of the number of minutes, ten (10) times a month for at least two (2) months in a semester or at least 
                    two (2) consecutive months during the year.”</i>

                    <br> <br>   
                    <div style=" text-indent: 5em">
                        <b>Habitual tardiness carries the following penalties:
                            <br> <br>   
                                    1st Offense	-	Reprimand <br>
                                    2nd Offense	-	Suspension for one (1) day to thirty (30) days <br>
                                    3rd Offense	-	DISMISSAL
                            <br><br>  
                         </b>
                    </div> 

                    Hence, you are hereby <b>ORDERED</b> to submit your written explanation within 48 hours <b>why you should not be suspended</b> for deliberately violating our office rules and regulations.
                    <br><br>    
                    Your utmost preferential attention is highly requested.
                    <br><br>  
                    For your compliance.
                        
                  
                    <br><br><br><br>
                    <b>VERONICA GRACE P. MIRAFLOR</b><BR>
                    CGDH I <br><br><br>
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
$pdf->Output($file_title.'Letter of Notice [Reprimand]', 'I');

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