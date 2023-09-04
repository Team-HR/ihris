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
$fullname = "MARIA JANSSEN A. EUMAGUE";
$address = "LOT 7 BLK 21 AMPAROS VILLAGE, BAYAWAN CITY";
$position_sg = "Administrative Officer IV(Human Resource Mgt. Officer II)- SG 15/1";
$employment_status = "Permanent";
$department = "City Administrator's Office";
$annual_salary_in_words = "--THREE HUNDRED FOURTEEN THOUSAND TWO HUNDRED FOURTY-FOUR--";
$annual_salary = "(P 314,244.00)";
$promotion = "Promotion";
$vacated_by = "VERONICA GRACE P. MIRAFLOR";
$reason_vacated = "Promotion";
$item_no = "ADM-7.1";
$plantilla_page_no = "2";
$approved_plantilla_year = "Approved Plantilla of Personnel CY 2017.";
$mayor = "PRYDE HENRY A. TEVES";
$date_of_signing = "June 01, 2017";

$html = <<<EOD
<div style="position: fixed; left: 230px; top: 35px;">
    <img src="../bayawanLogo.png" width="60">
</div>
<div style="border: 3px double black;">
<table style="width:100%;">
    <tr><td colspan="5" style="font-size: 10px;">KSS PORMA BLG. 33. <br> (Narebisa 1998)</td></tr>
    <tr>
        <td colspan="5" style="text-align:center;">Republic of the Philippines<br>Province of Negros Oriental<br>City of Bayawan</td>
    </tr>
    <tr><td height="30"></td></tr>
    <tr>
        <td width="150">Ginoong/Gng/Bb.:</td>
        <td colspan="4"><strong>$fullname</strong></td>
    </tr>
    <tr>
        <td width="150" style="vertical-align:top;"><i style="font-size: 10px;">Mr./ Mrs./ Ms.</i></td>
        <td colspan="4">$address</td>
    </tr>
    <tr><td height="10"></td></tr>
    <tr>
        <td width="150" style="padding-left: 15px;">Kayo ay nahirang<br><i style="font-size: 10px;">You are hereby appointed as</i> </td>
        <td colspan="3" style="border-bottom: 1px solid black; text-align:center;">$position_sg</td>
        <td width="100">na</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="2" style="text-align:center;">$department</td>
    </tr>
    <tr>
        <td width="150">May katayuang</td>
        <td style="border-bottom: 1px solid black; text-align:center;">$employment_status</td>
        <td width="50" align="center">sa</td>
        <td colspan="2" style="border-bottom: 1px solid black; text-align:center;">LGU-Bayawan City</td>
    </tr>
    <tr>
        <td width="150" align="center"></td>
        <td style="text-align:center; vertical-align:top;"><i style="font-size: 10px;">(Status)</i></td>
        <td width="50" style="text-align:center; vertical-align:top;"><i style="font-size: 10px;">at the</i></td>
        <td colspan="2" style="text-align:center; vertical-align:top;"><i style="font-size: 10px;">(Agency)</i></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align:center; white-space: nowrap; padding-left: 70px;">$annual_salary_in_words</td>
    </tr>
    <tr>
        <td width="150">Sa pasahod na</td>
        <td colspan="3" style="border-bottom: 1px solid black; text-align:center; white-space: nowrap;">$annual_salary</td>
        <td>piso</td>
    </tr>
    <tr>
        <td width="150" align="center"><i style="font-size: 10px;">with a compensation rate of</i></td>
        <td colspan="3"></td>
        <td style="text-align:center;"><i style="font-size: 10px;">pesos per annum</i></td>
    </tr>
    <tr>
        <td colspan="5" style="text-align:left; padding-left: 50px; padding-top: 5px;">
            Ito ay magkakabisa sa petsa ng pagtanggap ng tungkulin subalit di aaga sa petsa ng pagpirma<br>
            <i style="font-size: 10px;">This shall take effect on the date of actual assumption by the appointee but not earlier than the date of issuance/signing</i>
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align:left;">
            ng puno ng tanggapan o pinunong tagahirang.<br>
            <i style="font-size: 10px;">of the head of agency or the appointing authority</i>
        </td>
    </tr>
</table>
<table style="width:100%">
    <tr>
        <td style="width: 200px; text-align:left; padding-left: 30px;">Ang paghirang na ito ay</td>
        <td colspan="3" style="border-bottom: 1px solid black; text-align:center;"><strong>$promotion</strong></td>
        <td>bilang kapalit ni</td>
    </tr>
    <tr>
        <td style="width: 200px; text-align:left; padding-left: 30px;"><i style="font-size: 10px;">This appointment is</i></td>
        <td colspan="3" style="text-align:center;"><i style="font-size: 10px;">(Original, Promotion, etc...)</i></td>
        <td><i style="font-size: 10px;">as replacement of</i></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom: 1px solid black; text-align:center;"><strong>$vacated_by</strong></td>
        <td width="50" align="center">sa</td>
        <td style="border-bottom: 1px solid black; text-align:center;"><strong>$reason_vacated</strong></td>
        <td width="150">at ayon sa Plantilya</td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td align="center"><i style="font-size:10px;">who</i></td>
        <td align="center"><i style="font-size:10px;">(Transferred , Retired, etc...)</i></td>
        <td align="center"><i style="font-size:10px;">and in accordance with Plantilla</i></td>
    </tr>
    <tr>
        <td>Aytem Blg. <u><strong>$item_no</strong></u><br><i style="font-size: 10px;">Item No.</i></td>
        <td>Pahina <u><strong>$plantilla_page_no</strong></u><br><i style="font-size: 10px;">Page</i></td>
        <td colspan="3"><strong>$approved_plantilla_year</strong></td>
    </tr>
    <tr><td height="30"></td></tr>
</table>
<table style="width:100%;">
<tr>
<td colspan="2"></td>
<td colspan="3">Sumasainyo,</td>
</tr>
<tr>
<td colspan="2">As Authorized under Resolution</td>
<td colspan="3"><i style="font-size:10px;">Very Truly Yours,</i></td>
</tr>
<tr>
<td colspan="2">No.1201478 dated September 26, 2012.</td>
<td colspan="3"></td>
</tr>
<tr>
<td colspan="2">CSC Accreditation Program.</td>
<td colspan="2" style="text-align:center; border-bottom: 1px solid black;"><strong>$mayor</strong></td>
<td></td>
</tr>
<tr>
<td colspan="2"></td>
<td colspan="2" style="text-align:center;"><strong>CITY MAYOR</strong></td>
<td></td>
</tr>
<tr>
<td colspan="2">APPROVED AS PERMANENT:</td>
<td colspan="2" style="text-align:center;">Puno ng Tanggapan</td>
<td></td>
</tr>
<tr>
<td colspan="2"></td>
<td colspan="2" style="text-align:center;"><i style="font-size: 10px;">Head of Agency</i></td>
<td></td>
</tr>
<tr><td height="30"></td></tr>
<tr>
<td style="text-align:center; border-bottom: 1px solid black;"><strong>$mayor</strong></td>
<td width="55"></td>
<td colspan="2" style="text-align:center; border-bottom: 1px solid black;"><strong>$date_of_signing</strong></td>
<td></td>
</tr>
<tr>
    <td style="text-align:center;"><strong>CITY MAYOR</strong> <sup><i style="font-size: 8px;">(xyz)</i></sup></td>
    <td width="55"></td>
    <td colspan="2" style="text-align:center;">Petsa ng Pagpirma</td>
    <td></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td colspan="2" style="text-align:center;"><i style="font-size: 10px;">Date of Signing</i></td>
    <td></td>
</tr>
<tr>
    <td align="center">Awtorisadong Opisyal</td>
    <td colspan="4"></td>
</tr>
<tr>
    <td align="center">Komisyon ng Serbisyo Sibil</td>
    <td colspan="4"></td>
</tr>
<tr>
    <td align="center"><i style="font-size: 10px;">Authorized Official/Civil Service Commission</i></td>
    <td colspan="4"></td>
</tr>
<tr><td height="100"></td></tr>
<tr>
    <td align="center" style="border-bottom: 1px solid black;"></td>
    <td colspan="4"></td>
</tr>
<tr>
    <td align="center">Petsa</td>
    <td colspan="4"></td>
</tr>
<tr>
    <td align="center"><i style="font-size: 10px;">Date</i></td>
    <td colspan="4"></td>
</tr>
</table>
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