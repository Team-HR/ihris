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

$rspcomp_id = $_GET['rspcomp_id'];
$sql = "SELECT *, `rsp_vacant_positions`.`education` AS `education_cri`, `rsp_vacant_positions`.`experience` AS `experience_cri`,`rsp_vacant_positions`.`training` AS `training_cri`, `rsp_vacant_positions`.`eligibility` AS `eligibility_cri` FROM `rsp_comparative` JOIN  `rsp_vacant_positions` ON `rsp_comparative`.`rspvac_id` = `rsp_vacant_positions`.`rspvac_id` JOIN `rsp_applicants` ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rsp_comparative`.`rspcomp_id`=$rspcomp_id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$name = $row['name'];
$sg = $row['sg'];
$positiontitle = $row['positiontitle'];
$education_cri = $row['education_cri'];
$experience_cri = $row['experience_cri'];
$training_cri = $row['training_cri'];
$eligibility_cri = $row['eligibility_cri'];

// check if rscomp_id has already a checklist
$sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$data = array();
if ($result->num_rows>0) {
  $data = unserialize($row['data']);
}

foreach ($data as $key => $value) {
    // echo (isset($data[0]['polarity'];
    // echo var_dump($value)."<br>";

}
    
    $file_title ="";      
    $file_title = $positiontitle." - ";
    $position_title = $positiontitle;
    

    $education = lister(unserialize($education_cri));
    $training = lister(unserialize($training_cri));
    $experience = lister(unserialize($experience_cri));
    $eligibility = lister(unserialize($eligibility_cri));



// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FranzDev');
$pdf->SetTitle($file_title.'Appointment Processing Checklist');

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

$pdf->Write(0, 'Appointment Processing Checklist', '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, 'CSCFO-Negros Oriental', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);
$dateOfUse = date('F d, Y');
// -----------------------------------------------------------------------------
$func = function ($fn) {
    return $fn;
};
$tbl = <<<EOD
<table cellspacing="0" cellpadding="2" border="1">
    <tr>
        <td width="10%"><b>Name</b></td>
        <td width="60%" colspan="2"> {$func(strtoupper($name))}</td>
        <td editable width="16%"><b>Same name in PDS</b></td>
        <td width="7%" align="center">{$func(checker("1",(isset($data[0]['polarity'])?$data[0]['polarity']:'none')))} YES</td>
        <td width="7%" align="center">{$func(checker("0",(isset($data[0]['polarity'])?$data[0]['polarity']:'none')))} NO</td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>Position Title</b></td>
        <td width="55%" colspan="2"> {$func(strtoupper($position_title))}</td>
        <td width="16%"><b>SG/Step</b></td>
        <td width="14%" colspan="2" align="center"> $sg</td>
    </tr>
    <tr>
        <td width="10%"><b>Agency</b></td>
        <td width="60%" colspan="2"> LGU BAYAWAN CITY</td>
        <td width="16%"><b>Compensation</b></td>
        <td width="14%" colspan="2" align="center">{$func((isset($data[44]['remarks'])?$data[44]['remarks']:''))}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><i><b>CRITERIA</b></i></td>
        <td width="4%" align="center"><b>YES</b></td>
        <td width="4%" align="center"><b>NO</b></td>
        <td width="22%" align="center"><b><i>REMARKS</i></b></td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>QS: 1. Education</b></td>
        <td width="55%">$education</td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[1]['polarity'])?$data[1]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[1]['polarity'])?$data[1]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[1]['remarks'])}</td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Experience</b></td>
        <td width="55%">$experience</td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[2]['polarity'])?$data[2]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[2]['polarity'])?$data[2]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[2]['remarks'])}</td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Training</b></td>
        <td width="55%">$training</td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[3]['polarity'])?$data[3]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[3]['polarity'])?$data[3]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[3]['remarks'])}</td>
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Elig.</b></td>
        <td width="55%">$eligibility</td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[4]['polarity'])?$data[4]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[4]['polarity'])?$data[4]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[4]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4a. If  practice of profession -valid license;drivers-Cert allowed</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[5]['polarity'])?$data[5]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[5]['polarity'])?$data[5]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[5]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>5.&nbsp;&nbsp;&nbsp;&nbsp; -Other reqts: Residency (LGU Dept Heads)</b> <cite>Localization w/n 6 mos residency</cite></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[6]['polarity'])?$data[6]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[6]['polarity'])?$data[6]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[6]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>5a. Check if info in PUBLICATION is correct (plantilla item#, QS, etc)</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[7]['polarity'])?$data[7]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[7]['polarity'])?$data[7]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[7]['remarks'])}</td>
    </tr>
    <tr>
        <td width="100%"><i><b>COMMON REQUIREMENTS</b></i></td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>6. CS Form in triplicate</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[8]['polarity'])?$data[8]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[8]['polarity'])?$data[8]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[8]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>7. Employment Status</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[9]['polarity'])?$data[9]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[9]['polarity'])?$data[9]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[9]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>8. Nature of Appointment</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[10]['polarity'])?$data[10]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[10]['polarity'])?$data[10]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[10]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>9. Signature of Appointing Authority (all original)</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[11]['polarity'])?$data[11]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[11]['polarity'])?$data[11]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[11]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>10. Date of Signing</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[12]['polarity'])?$data[12]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[12]['polarity'])?$data[12]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[12]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>11. Certification by HRMO: in order, Publ./Posting of Vacany</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[13]['polarity'])?$data[13]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[13]['polarity'])?$data[13]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[13]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>12. Certification by PSB Chair at back of apntmt (or Copy of PSB mins.)</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[14]['polarity'])?$data[14]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[14]['polarity'])?$data[14]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[14]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>13. Same Item No, and Position Title in POP?</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[15]['polarity'])?$data[15]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[15]['polarity'])?$data[15]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[15]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>14. PDS.</b> <small>(new form) completely filled out, w/ signature of swearing officer, date subscribed , no blank (write n/a)</small></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[16]['polarity'])?$data[16]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[16]['polarity'])?$data[16]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[16]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>14a. PDF-QS for position, not of appointee; Actual duties/fuunctions</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[17]['polarity'])?$data[17]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[17]['polarity'])?$data[17]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[17]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>15. If accredited, submitted within 30 days of succeeding month?</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[18]['polarity'])?$data[18]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[18]['polarity'])?$data[18]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[18]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>16. If regulated, submitted within 30 days from issuance?</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[19]['polarity'])?$data[19]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[19]['polarity'])?$data[19]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[19]['remarks'])}</td>
    </tr>
    <tr>
        <td width="100%"><i><b>ADDITIONAL REQUIREMENTS</b></i></td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>17. If w/ erasures - initialed & w/ Cert of Erasures/Alterations by AA</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[20]['polarity'])?$data[20]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[20]['polarity'])?$data[20]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[20]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>18. If w/ decided admin/crim case-CTC of decision from deciding body</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[21]['polarity'])?$data[21]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[21]['polarity'])?$data[21]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[21]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>19. If with discrepancy in personal info: CSC Reso or Order</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[22]['polarity'])?$data[22]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[22]['polarity'])?$data[22]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[22]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>19a. If promotion & employee been found guilty of admin case & suspension or fine was imposed: Cert by appointing autho as to when decisions became final & when penalty was served</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[23]['polarity'])?$data[23]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[23]['polarity'])?$data[23]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[23]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>20. COMELEC ban: COMELEC exemption</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[24]['polarity'])?$data[24]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[24]['polarity'])?$data[24]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[24]['remarks'])}</td>
    </tr>
    <tr>
        <td width="10%" rowspan="4"><b>21. LGU:</b></td>
        <td width="60%"><b>Cert by AA-aptmt issued in accordance w/ limitns in RA 7160</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[25]['polarity'])?$data[25]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[25]['polarity'])?$data[25]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[25]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>Cert by Accountant-funds available</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[26]['polarity'])?$data[26]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[26]['polarity'])?$data[26]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[26]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>Dept Head: Sanggunian Reso-concurrence of majority; or Cert by Sasnggunian Sec/HRMO confirm'g non-action by Sanggunian w/n 15 days from date of submission</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[27]['polarity'])?$data[27]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[27]['polarity'])?$data[27]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[27]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>If creation/recals & w/ appropriation: Sang.ordinance-subj to review by SP if component cities/muni; by DBM if province</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[28]['polarity'])?$data[28]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[28]['polarity'])?$data[28]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[28]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>22. Appointment involving change of status from temp to perm under cats.in MC 11s1996:CAT.I TESDA cert; CAT.II-Perf rating 2 periods;CAT.IV-license</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[29]['polarity'])?$data[29]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[29]['polarity'])?$data[29]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[29]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>23. Non-Disciplinary Demotion: Cert by AA that demotion is not a result of an admin case PLUS written consent of appointee</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[30]['polarity'])?$data[30]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[30]['polarity'])?$data[30]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[30]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>24. Oath of Office (Gov't ID, ID# & Date issued) & Assumption</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[31]['polarity'])?$data[31]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[31]['polarity'])?$data[31]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[31]['remarks'])}</td>
    </tr>
    <tr>
        <td width="100%"><i><b>OTHER REQUIREMENTS</b></i></td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Temporary/Provisional aptmt: Cert by AA vouching absence of eligible</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[32]['polarity'])?$data[32]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[32]['polarity'])?$data[32]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[32]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Reclassification: NOSCA approved by DBM/Memo Order by GCG</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[33]['polarity'])?$data[33]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[33]['polarity'])?$data[33]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[33]['remarks'])}</td>
    </tr>
    <tr>
        <td width="10%" rowspan="4"><b>Nature</b></td>
        <td width="60%"><cite>If Orig. first-time perm from noncareer, reap frm temp to perm, reemp under perm, first time to closed career, provisional, cat.3:</cite> <b>"The appointee shall undergo probationary period..."</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[34]['polarity'])?$data[34]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[34]['polarity'])?$data[34]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[34]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>If Promotion, VS rating for 1 rating period in present position</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[35]['polarity'])?$data[35]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[35]['polarity'])?$data[35]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[35]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>If Promotion, not more than 3 SGs higher - JUSTIFICATION</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[36]['polarity'])?$data[36]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[36]['polarity'])?$data[36]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[36]['remarks'])}</td>
    </tr>
    <tr>
        <td width="60%"><b>If Transfer, copy of previous appointment</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[37]['polarity'])?$data[37]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[37]['polarity'])?$data[37]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[37]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Plantilla info: name of replaced employee, Plantilla Item# and Page</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[38]['polarity'])?$data[38]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[38]['polarity'])?$data[38]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[38]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Issued after election up to June 30 by outgoing elective AA</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[39]['polarity'])?$data[39]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[39]['polarity'])?$data[39]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[39]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Lost in the last election, except Brgy Election</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[40]['polarity'])?$data[40]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[40]['polarity'])?$data[40]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[40]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Citizenship (if dual, should renounce & not use foreign passport, unless acquired by birth)</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[41]['polarity'])?$data[41]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[41]['polarity'])?$data[41]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[41]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>Appointment received by the appointee - Name, Signature, Date</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[42]['polarity'])?$data[42]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[42]['polarity'])?$data[42]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[42]['remarks'])}</td>
    </tr>
    <tr>
        <td width="70%" colspan="3"><b>S-card completely filled out back to back? Not multiple s-card?</b></td>
        <td width="4%" align="center">{$func(checker("1",(isset($data[43]['polarity'])?$data[43]['polarity']:'none')))}</td>
        <td width="4%" align="center">{$func(checker("0",(isset($data[43]['polarity'])?$data[43]['polarity']:'none')))}</td>
        <td width="22%" align="center">{$func($data[43]['remarks'])}</td>
    </tr>
</table>
<table cellpadding="2">
    <tr>
        <td width="70%" colspan="3"></td>
        <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td>
    </tr>
    <tr>
        <td width="10%" border="1"></td>
        <td width="60%"><b>Approved/Validated</b></td>
        <td width="4%" border="1"></td>
        <td width="26%" colspan="2"><b>Disapproved/Invalidated</b></td>
    </tr>
    <tr>
        <td width="70%"><cite><i>Created & used on November 8, 2019</i></cite></td>
        <td width="30%" borderbottom="1" colspan="3"><b>Reasons:</b>_________________________________</td>
    </tr>
    <tr>
        <td width="60%" border="1"><b>Evaluated by:<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHOEBE P. TUPAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Supervising HR Specialist</cite>
        </b></td>
        <td width="40%" border="1">
        <b>Approved/Signed by:<br><br>
        DIR. MERLINDA F. QUILLANO&nbsp;&nbsp;&nbsp;&nbsp;Date:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Director II</cite>
        </b></td>
    </tr>
</table>
EOD;
// $html = utf8_encode($html);
$pdf->writeHTML($tbl, true, false, false, false, '');

// $pdf->writeHTML($tbl, true, false, false, false, '');
// -----------------------------------------------------------------------------

//Close and output PDF document
$pdf->Output($file_title.'Appointment_Checklist.pdf', 'I');

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

function checker($pole,$polarity){
    if ($pole === $polarity) {
        return '<img src="check.png" alt="test alt attribute" width="10" height="10" border="0" />';
    }
    return "";
}