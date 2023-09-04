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
if (isset($_GET['rspvac_id']) && !empty($_GET['rspvac_id'])) {
  $rspvac_id = $_GET['rspvac_id'];
  $where ="WHERE `rspvac_id`='$rspvac_id';";
  $sql = "SELECT * FROM `rsp_vacant_positions`".$where; //";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();  
  $file_title = $row['positiontitle']." - ";
}


$sql = "SELECT * FROM `rsp_vacant_positions`".$where; //";
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FranzDev');
$pdf->SetTitle($file_title.'Appointment Processing Checklist');

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

$pdf->Write(0, 'Appointment Processing Checklist', '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, 'CSCFO-Negros Oriental', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
// -----------------------------------------------------------------------------
$position_title = strtoupper($position_title);

$tbl = <<<HTML
HTML;

$pdf->writeHTML($tbl, true, false, false, false, '');
}
// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Appointment_Checklist.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+