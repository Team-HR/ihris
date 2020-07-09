<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P',
    'margin_top' => 0.5,
	'margin_left' => 0.5,
    'margin_right' => 0.5,
    'margin_bottom' => 0.5,
    'margin_footer' => 0.5,
    'default_font' => 'helvetica'
]);
$department_id = 21;
$department = "";
$sql = "SELECT `department` from `department` WHERE `department_id` = '$department_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$department = strtoupper($row["department"]);

$mpdf->Bookmark('Start of the document');
$html = <<<EOD

<table width="100%" style="font-family: times; background: url(bayaswanLogo.png);background-repeat: no-repeat;background-position: center;" >
    <tr>
        <td align="center" width="50%" style="border: 1px solid lightgrey;">
    <table width="100%">
        <tr>
            <td align="right" width="">
                <img src="bayawanLogo.png" width="70" style="display: inline-block">     
            </td>
            <td align="center" color="darkred">
                Republic of the Philippines<br>
                Province of Negros Oriental<br>
                <strong>Bayawan City</strong>
            </td>
            <td width="10%"></td>
        </tr>
        <tr><td colspan="3" height="20"></td></tr>
        <tr>
            <td colspan="3" align="center" style="padding: none">
                <img src="bayawanLogo.png" width="120" height="120" style="border: 1px solid black;">
            </td>
        </tr>
        <tr><td colspan="3" height="20"></td></tr>
        <tr>
            <td colspan="3" align="center">
                <div style="border: 1px solid GREEN;">
                    
                </div>
<table width="100%">
    <tr>
        <td width="20"></td>
        <td padding="20" align="center" style="border: 1px solid black; background: url(bayawanLogo.png);background-repeat: no-repeat;background-position: center;">
            <strong color="#313182" style="font-size: 30px;">VALENCIA</strong><br>
            <strong color="#313182" style="font-size: 30px;">FRANZ JOSHUA A.</strong>
        </td>
        <td width="20"></td>
    </tr>
    <tr><td colspan="3" height="50"></td></tr>
    <tr>
        <td width="20"></td>
        <td padding="20" align="center" color="darkred">
            <strong>ID NO: 1234</strong>
        </td>
        <td width="20"></td>
    </tr>
</table>
            </td>
        </tr>
        <tr><td colspan="3" height="20"></td></tr>
    </table>
        </td>
        <td align="center" width="50%" valign="bottom" style="border: 1px solid lightgrey;">



<table width="100%">
<tr><td colspan="4" height="25"></td></tr>
<tr>
    <td colspan="4" align="center">Signature</td>
</tr>
<tr><td colspan="4" height="25"></td></tr>
<tr>
    <td colspan="4" align="center">Signature of Dep't Head</td>
</tr>
<tr><td colspan="4" height="25"></td></tr>
<tr>
    <td colspan="4" align="center">PRYDE HENRY A. TEVES</td>
</tr>
<tr>
    <td colspan="4" align="center">City Mayor</td>
</tr>
<tr><td colspan="4" height="10"></td></tr>
<tr>
    <td width="25"></td>
    <td align="left">Address:</td>
    <td width="20"></td>
    <td align="left">San Vicente, Brgy. Villareal, Bayawan City</td>
</tr>
<tr>
    <td width="25"></td>
    <td align="left">Gender:</td>
    <td width="20"></td>
    <td align="left">Male</td>
</tr>
<tr>
    <td width="25"></td>
    <td align="left">Date of Birth:</td>
    <td width="20"></td>
    <td align="left">September 9, 1994</td>
</tr>
<tr>
    <td width="25"></td>
    <td align="left">Place of Birth:</td>
    <td width="20"></td>
    <td align="left">Dumaguete City</td>
</tr>
<tr>
    <td width="25"></td>
    <td align="left">Contact No:</td>
    <td width="20"></td>
    <td align="left">09161498007</td>
</tr>
<tr><td colspan="4" height="10"></td></tr>
<tr>
    <td width="25"></td>
    <td align="left">VALIDITY:</td>
    <td width="20"></td>
    <td align="left">June 01 - July 30, 2020</td>
</tr>
<tr><td colspan="4" height="30"></td></tr>
<tr>
    <td colspan="4" align="center" color="black" style="font-size: 10px; padding: none;">Note: If found, please return to:<br>
        HRMO, LGU-Bayawan City<br>
        Tel. No.: (035) 531 - 0020 loc. 1065
    </td>
</tr>
</table>


        </td>
    </tr>
</table>
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