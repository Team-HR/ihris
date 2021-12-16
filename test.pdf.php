<?php
//============================================================
// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf_import.php');
require_once('_connect.db.php');

$num_rows = 8;
$num_employees_per_page = 0;
$department = "CITY TREASURER'S OFFICE";
$employees = array(
    "SUMALPONG, GEMMA G.",
    "ACABAL, BERNARDO  A.",
    "AMADEO, ROVILLA V.",
    "ADAPON, SHERYL G.",
    "ALVIOLA, EDGARDO A.",
    "ASPAREN, SARITA ALICIA N.",
    "ATAY, SUSAN V.",
    "BALASABAS, MA. CLARETTE T.",
    "BARRON, EMERALD A.",
    "BAYNOSA, LODEBER T.",
    "CORDEVILLA, CHUCHO V.",
    "DUHAYLUNGSOD, WILLIAM P., JR.",
    "ESTIÑOSO, MA. JEZEBEL G.",
    "GANTALAO, MARICON C.",
    "GERONA, HENELYN D.",
    "GOTLADERA, ARNEL ANTONIO Q.",
    "GOTLADERA, GREMAR Y.",
    "GRACIADAS, SYLVIA S.",
    "HOYOHOY, JENETTE B.",
    "JAMANDRON, JOHNJAY F.",
    "JOSEPH, FE JANET B.",
    "LACSON, VICTORIO S.",
    "MAPUTY, WILDE G.",
    "MARTINEZ, ELENITA M.",
    "MELENDRES, RUSSEL IRA B.",
    "MONCAL, RACHEL B.",
    "OCCEÑA, DEMETRIO S.",
    "OJEÑOS, IAN A.",
    "GALABAY, EMMEROSE O.",
    "PIÑERO, ARGEL JOSEPH L.",
    "PIÑERO, NOVA V.",
    "QUINDO, NOEL T.",
    "RUSIANA, JONATHAN T.",
    "SENIEL, FRETCHIE",
    "TABILON, ROSALINDA A.",
    "TATON, DIOSAN T.",
    "TIGMO, ELVIE CARMEL A.",
    "TORALDE, MENCHU V.",
    "TUBESA, JUVY D.",
    "VILLARIN, MA. RAYZA E.",
    "YURONG, CHRISTOPHER S.",
    "VECENTE M. BERONIO",
    "REY V. CORDOVA",
    "JUDITH T. DUKA",
    "VILMA G. RENDON",
    "TALEON, GALILEO T.",
    "TRIAS, JOAN",
    "YAP, DEEVI COREN S.",
    "ABADIANO, BEATRIZ",
    "ABRASALDO, JUN EARL T.",
    "ARROYO, ESTELA",
    "BACARAT, AMERSHAD M.",
    "BALUCOS, NOEMIE P.",
    "BAWEGA,  RONEL L.",
    "CADALSO, JUNERALLEN Y.",
    "CANCIO, RESELITO D.",
    "CATID, NOVALIE",
    "DILOY, MAYRIE JOY",
    "DUHAYLUNGSOD, GEMMA",
    "ENRIQUEZ, GODOFREDO ANTHONY II, M.",
    "ESNARDO, RYAN",
    "MASAYON, MARC ERIC E.",
    "MEMIS, MARLON S.",
    "PABRO, PAUL XERZIES Y.",
    "PALAMOS, LESLIE A.",
    "PAMILAGA, ALLEN JOHN",
    "PAPASIN, NOEL Q. JR.",
    "SANOY, ARNIEL",
    "SAYSON, JUDITO",
    "SUMALPONG, IAN",
    "TABAY, KERR A.",
    "TIGLE, OLIVER JR., M.",
    "TULAYBA, ARIANNE G.",
    "VILLAMIL, LILY H.",
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

// // set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'TEST_HEADER');

// // set header and footer fonts
// $pdf->setHeaderFont(Array('times', 'I', 9));
// $pdf->setFooterFont(Array('times','',9));

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

// set font
// $pdf->SetFont('helvetica', 'I', 20);
// add a page



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
        $emp1 = $employees[((($num_rows*$p)+$i)*2)];
        $emp2 = $employees[((($num_rows*$p)+$i)*2)+1];
        $department1 = $emp1?$department:'';
        $department2 = $emp2?$department:'';
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