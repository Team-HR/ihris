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
$pdf->SetTitle($file_title.'CS FORM NO. 33-B');

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
                                         Ms. <b><u>Emmerose O. Galabay</u></b>
            </p>   

            <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3"> 
                                      You are hereby appointed as <b><u>Revenue Collection Clerk II</u></b> <u><b>(SG 7, step 1)</u></b> under <b><u>Permanent</u></b> status at the <b><u>City Treasurer's Office, LGU Bayawan City</u></b> with a comepensation rate of <b><u>Fifteen Thousand Six Hundred Thirty Five</u></b> <b><u>(P 15,635.00)</u></b> pesos per month.
            </p>

            <p style="font-size:15px; text-align: justify; text-indent:30px; line-height:3" class="small"> 
                                       The nature of this appointment is <b><u>Promotion</u></b> vice <b><u>Maria Jainie T. Narito</u></b> , who <b><u>Retired</u></b> with Plantilla Item No. <b><u>CTO-18</u></b> Page ____.</p>

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
                          <u>PYRDE HENRY A. TEVES</u>
                          &nbsp;&nbsp;&nbsp;&nbsp;<br> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <cite>City Mayor</cite></b>

                          <br><br><br>
                          <b  style="font-size:15px";align="center"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <u>MAY 28, 2020</u>
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
                      This is to certify that all requirements ans supporting papers pursuant to CSC MC.No.<u><b>14</b></u>, series of <u><b>2018</b></u> 
                     have been complied with, reviewed and found to be in order.
                     <br>  <br>
                     The position was published at <u><b>CSC Job Portal</b></u>  on <u><b>February 6, 2020</b></u> to <u><b>February 21, 2020</b></u> and posted
                       in <u><b>BVP and 3 conspicuous places</b></u> from <u><b>February 6, 2020</b></u> to <u><b>February 21, 2020</b></u> in consonance with <u><b>RA No. 7041</b></u>. The assessment by the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on</b> <u><b>February 22-24,2020</b></u>
                </td>
            </tr>
            <br>
            <tr>
                <td width="45%" style="font-size:18px" align="center"></td>
                <td width="55%">
                            <b  style="font-size:15px">
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>VERONICA GRACE P. MIRAFLOR</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>HRMO IV</cite>
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
                    This is to certify that the appointee has been screened and found qualified by the majority of the <b>Human Resource Merit Promotion and Selection Board(HRMPSB) started on</b> during the deliberation held on <u><b>March 24, 2020</b></u> 
                </td>
            </tr>
            <br>
            <tr>
                <td width="45%" style="font-size:18px" align="center"></td>
                <td width="55%">
                            <b  style="font-size:15px">
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>ENGR. JERMEMIAS C. GALLO</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>
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
                    <i> Received original photocopy of appointment on ___________</i><br>
                    <br>
                    <b><u>EMMEROSE O. GALABAY</u></b><br>
                    Appointee
                </td>
            </tr>
       </table>
  </div>
</div>





EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Certificate Form No. 33.pdf', 'I');

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
   