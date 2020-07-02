<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'B4-P',
    'margin_top' => 15,
	'margin_left' => 5,
    'margin_right' => 5,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);

$scs_mc_no = "40";
$csc_bulletin_no = "CSC BULLETIN NO. 123-2017";


$html = <<<EOD
<div style="border: 3px double black;">
<br>
<hr style="color:black;">
    <h4 align="center" style="padding: none; margin: none;">SERTIPIKASYON</h4>
<hr style="color:black;">
<div style="margin-left: 70px; margin-top: 20px;">
    <table width="100%" style="font-size: 17px;">
        <tr><td>Ito ay pagpatunay na lahat ng dapat gawin at mga kailangang dokumento para sa appointment na ito</td></tr>
        <tr><td><i style="font-size: 11px;">This is to certify that all requirment and supporting papers for this appointment</i></td></tr>
    </table>
</div>
<br>
<div style="margin-left: 20px;">
    <table width="100%" style="font-size: 17px;">
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
</table>
</div>

</div>
EOD;
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