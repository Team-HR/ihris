<?php
//============================================================
// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf_import.php');
require_once('_connect.db.php');

$num_rows = 8;
$num_employees_per_page = 0;
$department = "CITY ENVIRONMENT AND NATURAL RESOURCES OFFICE";
$employees = array(
    "VILLARUBIA, NEFREDO A.",
    "AGUILAR, ANTONIO JR., S",
    "BOLLOS,  ION JOSEPH T. ",
    "TORRENTO, EUGENE RUSTICO T.",
    "PATIGAYON, AMELYN T.",
    "STELLA DWAYNE P. BETANIA",
    "MONTES, JULIETA M. ",
    "CRISOSTOMO, JOEMAR E.",
    "HOYOHOY, ARTHUR S.",
    "VILLAMIL, KAREN THERESE",
    "AWAS, ABUNDIO P. JR.",
    "BAGARINAO, TITA M.",
    "BISABIS, RAUL Z.",
    "BOLLOS, MONICO GALEN E. JR.",
    "BOLTIADOR, GEOFREY V.",
    "DELA CRUZ, CARLITO D.",
    "EGANG, MARIA FLORA C.",
    "EMPERADO, NARDITO S.",
    "HOBRO, REBECCA L. ",
    "JAMIN, RENIE R.",
    "MARCELINO, JOEL B.",
    "OLORES, LEONARDO M.",
    "OMOYON, ELIZABETH L.",
    "PALMA, JUANITA A.",
    "PAO, CEASAR",
    "PASCO, LUCY P.",
    "PICANTE,PETER",
    "PRAC, DEDITO E.",
    "QUIO, DAISY D.",
    "RENDON, JERRY C.",
    "SARAÑA, BRENDO F.",
    "VALENCIA,EUGENE ",
    "VALOR, JOVELYN V.",
    "LORINAMAE CARLON",
    "ALLAN MANINANTAN JR.",
    "JOSEPHINE PANDAGANI",
    "JASON BARANGGAN",
    "EVA TABOGUILDE",
    "GEDA TIZON",
    "MARK ANTHONY BARO",
    "STEPHINE SAYCON",
    "ERVING MOSICO",
    "ESTER BAYLON",
    "REX QUINIQUITO",
    "WARREN GASENDO",
    "RUBEN BANDOQUILLO",
    "EDWARD CORDOVA",
    "DARLENE TENEFRANCIA",
    "ROLAND TOLENTIN",
    "ESTEB LUI CHIEFE",
);

$num_pages = get_num_pages($employees, $num_rows);

// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Franz Joshua Valencia');
$tab_title = $pdf->SetTitle("TEST_TITLE");
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(3, 3, 3, 3);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(FALSE, 0);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    // $pdf->setLanguageArray($l);
}

// start of for ($i=0; $i < $num_pages; $i++) { 
for ($p = 0; $p < $num_pages; $p++) {
    $pdf->AddPage();
    // $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetFont('helvetica', '', 9);
    // ------------------------------------------------------------------------------
    $tbl = <<< EOD
    <table border="1" style="table-layout:fixed; border-collapse: collapse; font-size:18px; text-align: center;">
EOD;
    for ($i = 0; $i < $num_rows; $i++) {
        $emp1 = $employees[((($num_rows * $p) + $i) * 2)];
        $emp2 = $employees[((($num_rows * $p) + $i) * 2) + 1];
        $department1 = $emp1 ? $department : '';
        $department2 = $emp2 ? $department : '';
        $tbl .= <<< EOD
    <tr>
        <td style="width:101mm; height: 36.3mm;">
            <h3>$emp1</h3>
            <span style="font-size:11px;">$department1</span>
        </td>
        <td style="width:101mm;">
            <h3>$emp2</h3>
            <span style="font-size:11px;">$department2</span>
        </td>
    </tr>
EOD;
    }
    $tbl .= <<< EOD
</table>
EOD;
    $pdf->writeHTML($tbl, true, false, false, false, '');


    // end of for ($i=0; $i < $num_pages; $i++) { 
}
// -----------------------------------------------------------------------------

//Close and output PDF document
$filename = "TEST.pdf";
//Change To Avoid the PDF Error
ob_end_clean();
$pdf->Output($filename, 'I');

//============================================================+
// END OF FILE
//============================================================+

function get_num_pages($employees, $num_rows)
{
    $length = count($employees);
    // $num_employees_per_page = $num_rows * 2;
    $num_pages = ceil($length / ($num_rows * 2));
    return $num_pages;
}
