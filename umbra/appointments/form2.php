<?php
require "../vendor/autoload.php";
require "../_connect.db.php";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'FOLIO-P',
    'margin_top' => 15,
	'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);

$scs_mc_no = "40";
$csc_bulletin_no = "CSC BULLETIN NO. 123-2017";
$date_of_publication = "May 08, 2017";
$hrmo = "VERONICA GRACE P. MIRAFLOR";
$hrmo_position = "HRMO IV";
$date_qualified = "May 30, 2017";
$placement_committee_chairman = "JEREMIAS C. GALLO";
$html = <<<EOD
<div style="border: 3px double black;">
<br>
<table width="100%">
    <tr><td style="border-top: 1px solid black;"></td></tr>
    <tr><td align="center" style="padding: 10px;"><h4>SERTIPIKASYON</h4></td></tr>
    <tr><td style="border-bottom: 1px solid black;"></td></tr>
</table>
<div style="margin-left: 70px; margin-top: 20px;">
    <table width="100%" style="font-size: 12px;">
        <tr><td>Ito ay pagpatunay na lahat ng dapat gawin at mga kailangang dokumento para sa appointment na ito</td></tr>
        <tr><td><i style="font-size: 11px;">This is to certify that all requirment and supporting papers for this appointment</i></td></tr>
    </table>
</div>
<br>
<div style="margin-left: 20px;">
    <table width="100%" style="font-size: 12px;">
        <tr>
            <td colspan="3">ay ayon sa SCS MC No. <u><strong>$scs_mc_no</strong></u> s. 1998 ay nasunod na, narebisa at napatunayang nasa ayos.</td>
        </td>
        <tr>
            <td width="15%"><i style="font-size: 11px;">is pursuant to SC MC No.</i></td>
            <td width="5%"></td>
            <td><i style="font-size: 11px;">s. 1998 have been complied with, reviewed and found to be in order.</i></td>
        </tr>
    </table>
</div>
<div style="margin-top: 20px;">
<table width="100%">
    <tr>
        <td width="50%" style="padding-left: 70px;">Ang posisyon ay nalathala sa</td>
        <td width="40%" align="center" style="border-bottom: 1px solid black;"><strong>$csc_bulletin_no</strong></td>
        <td width="10%">noong</td>
    </tr>
    <tr>
        <td style="padding-left: 70px;"><i style="font-size: 11px;">This position was published in</i></td>
        <td width="30%"></td>
        <td><i style="font-size: 11px;">on</i></td>
    </tr>
    <tr><td height="20"></td></tr>
    <tr>
        <td width="40%" align="center" style="border-bottom: 1px solid black;"><strong>$date_of_publication</strong></td>
        <td colspan="2">.</td>
    </tr>
    <tr><td height="20"></td></tr>
    <tr>
        <td style="padding-left: 70px;"></td>
        <td width="30%" align="center" style="border-bottom: 1px solid black;"><strong>$hrmo</strong></td>
        <td></td>
    </tr>
    <tr>
        <td style="padding-left: 70px;"></td>
        <td width="30%" align="center">$hrmo_position</td>
        <td></td>
    </tr>
</table>
<table style="width: 100%;"><tr><td style="border-top: 3px double black;" height="1"></td></tr></table>
</div>
<br>
<table width="100%">
    <tr><td style="border-top: 1px solid black;"></td></tr>
    <tr><td align="center" style="padding: 10px;"><h4>SERTIPIKASYON</h4></td></tr>
    <tr><td style="border-bottom: 1px solid black;"></td></tr>
</table>
<div style="margin-top: 20px;">
    <table width="100%" style="font-size: 12px;">
        <tr><td style="padding-left: 70px;">Ito ay pagpatunay na ang nahirang ay nagdaan sa pagsusuri at napatunayang kwalipikado ng</td></tr>
        <tr><td style="padding-left: 70px;font-size: 11px;"><i>This is to certify that appointee has been screened and found qualified by the </i> <strong>Personnel Selection Board</strong></td></tr>
        <tr><td>On $date_qualified</td></tr>
        <tr><td height="20"></td></tr>
        <tr><td>Placement Committee</td></tr>
        <tr><td style="font-size: 11px;"><i>Placement Committee</i></td></tr>
    </table>
    <table width="100%">
        <tr>
            <td width="50%" style="padding-left: 70px;"></td>
            <td width="40%" align="center" style="border-bottom: 1px solid black;"><strong>$placement_committee_chairman</strong></td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td width="50%" style="padding-left: 70px;"></td>
            <td width="40%" align="center">Chairperson</td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td width="50%" style="padding-left: 70px;"></td>
            <td width="40%" align="center">Placement Committee</td>
            <td width="10%"></td>
        </tr>
    </table>
    <br>
    <table style="width: 100%;"><tr><td style="border-top: 3px double black;" height="1"></td></tr></table>
</div>

<table width="100%" style="margin-top: 15px;">
    <tr><td style="border-top: 1px solid black;"></td></tr>
    <tr><td align="center" style="padding: 10px;"><h4>MGA NOTASYON</h4></td></tr>
    <tr><td style="border-bottom: 1px solid black;"></td></tr>
</table>
<table width="100%" style="font-size: 12px;">
    <tr>
        <td width="5%" valign="middle" align="center">( x )</td><td>Effective not earlier than the date of publication and subject for probationary period of six(6) months.</td>
    </tr>
    <tr><td colspan="2" style="border-bottom: 1px solid black;"></td></tr>
    <tr>
        <td width="5%" valign="middle" align="center">( y )</td><td>Provided that the salary is allowable under the existing laws.</td>
    </tr>
    <tr><td colspan="2" style="border-bottom: 1px solid black;"></td></tr>
    <tr>
        <td width="5%" valign="middle" align="center">( z )</td><td>Subject for official verification of her/his CS eligibility and provided that there is no pending administrative case filed against the proposed appointee.</td>
    </tr>
    <tr><td colspan="2" style="border-bottom: 1px solid black;"></td></tr>
</table>
<br>
<table style="width: 100%;"><tr><td style="border-top: 3px double black;" height="1"></td></tr></table>
<p style="margin-top: 15px;">ANUMANG BURA O PAGBABAGO SA AKSYONG GINAWA NG KOMISYON NG SERVISYO SIBIL AY MAGPAPAWALANG BISA SA PAGHIRANG NA ITO MALIBAN KUNG ANG PAGBABAGO AY NASULAT NA KINUKUMPIRMA NG KOMISYO/KSS.</p>
<table style="width: 100%; margin-top: 5px;"><tr><td style="border-top: 3px double black;" height="1"></td></tr></table>
<table width="100%" style="padding: 10px;">
<tr>
    <td width="30%">Petsa ng paglabas sa KSS/Komisyon</td>
    <td width="20%" style="border-bottom: 1px solid black;"></td>
    <td>.</td>
    <td width="50%"></td>
</tr>
</table>
<table style="width: 100%;"><tr><td style="border-top: 3px double black;" height="1"></td></tr></table>
<table style="margin-top:5px;">
    <tr>
        <td colspan="2">Mga Pagbibigyan ng Kopya:</td>
    </tr>
    <tr>
        <td style="padding-left: 70px;">Orihinal</td>
        <td style="padding-left: 70px;">Kopya ng Nahirang</td>
    </tr>
    <tr>
        <td style="padding-left: 70px;">Pangalawang Kopya</td>
        <td style="padding-left: 70px;">Para sa Komisyon ng Serbisyo Sibil</td>
    </tr>
    <tr>
        <td style="padding-left: 70px;">Pangatlong Kopya</td>
        <td style="padding-left: 70px;">Para sa Ahensiya</td>
    </tr>
</table>
</div>
EOD;

// ( x ) 
// 
// ( z ) Subject for official verification of her/his CS eligibility and provided that there is no pending administrative case filed against the proposed appointee.
$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);
$mpdf->Output();

function formatDate($date_in){
    if (!$date_in) return "";
    $date=date_create($date_in);
    return date_format($date,"m/d/Y");
}