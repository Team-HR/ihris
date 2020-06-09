<?php
    include_once "../../_connect.db.php";
    $yr = $_GET['feedBackYR'];
    $emp = $_GET['reference'];
    $sql = "SELECT * from `spms_feedbacking` 
            left join `employees` on `spms_feedbacking`.`feedbacking_emp`=`employees`.`employees_id` left join `department` on `department`.`department_id`=`employees`.`department_id` 
            where `feedbacking_emp`='$emp' and `feedbacking_year`='$yr'";
    $sql = $mysqli->query($sql);
    $data = $sql->fetch_assoc();
    $date = date("m-d-Y", strtotime($data['date_conducted']));
    $fullname = $data['lastName'].", ".$data['firstName'];




// Include the main TCPDF library (search for installation path).
require_once('../../TCPDF-master/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HR Personel');
$pdf->SetTitle('Spms Feedbacking');
$pdf->SetSubject('for printing');
$pdf->SetKeywords('Feedback');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '
    <h1 style="text-align:center">PERFORMANCE REVIEW & FEEDBACKING MONITORING FORM</h1>
    <br>
    <div>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.$fullname.'</u></div>
    <div>Department &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.$data['department'].'</u></div>
    <div>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.$date.'</u></div>
    <br>
    <div style="border:1px solid black">
        <div style="text-align:center">
            <b>FEEDBACKS</b>
        </div>
        <hr>
        <div>
           <table cellpadding="20">
                <tr>
                    <td>
                        '.$data['feedbacking_feedback'].'
                    </td>
                </tr>
           </table>            
        </div>
    </div>
    <div>Feedback Session Conducted: '.nl2br($_GET["feedBackYR"]).'</div>
    <br>
    <br>
    <br>
    <table style="text-align:center">
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><div style="border-top:1px solid black">Signature Overprinted Name</div></td>
        </tr>
    </table>


';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('feedback.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


?>