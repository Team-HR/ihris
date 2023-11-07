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
require "vendor/autoload.php";
// require_once('_connect.db.php');
// require "libs/NameFormatter.php";
// require "libs/NumberToWords.php";



$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8',
  'format' => 'A4',
  'margin_top' => 10.27,
  'margin_left' => 20.54,
  'margin_right' => 20.54,
  'margin_bottom' => 0.95,
  'margin_footer' => 1,
  'default_font' => 'Arial'
]);


$name = "______________________________";
$address = "___________________________________";
$position_title = "_________________________";
$printed_name = "___________________________________";

$gov_id_type = "_________________";
$gov_id_num = "_________________";
$gov_id_date_issued = "_________________";

$sworn_day = "__________";
$sworn_month = "____________";
$sworn_year = "______________";
$sworn_address = "<u>New City Hall, Cabcabon Hills, Barangay Banga, Bayawan City, Negros Oriental, Philippines</u>";

$city_mayor = "_________________________________";

$html = <<<HTML
<div style="width: 21cm; font-family: arial;">
    <b style="font-size:15px;">CS Form No.32</b><br>
    <i>Revised 2017</i>
    <br><br><br>
   <div style="text-align:center;">
    <b style="font-size:17px"> REPUBLIC OF THE PHILIPPINES</b>
    <div style="font-size:15px"> Province of Negros Oriental</div>
    <div>City of Bayawan</div>
    <br><br>
    <b style="font-size:20px">OATH OF OFFICE</b>
    <br><br>
    <br><br>
  </div>
                     <p style="font-size:16px; text-align: justify; text-indent:30px" class="small"> I, {$name} of {$address} having been appointed to the position of {$position_title} hereby solemly swear, that I will faithfully discharge to the best of my ability, the duties of my present position and all of others that I may hereafter holf under the Republic of the Philippines; that I will bear true faith and allegiance to the same; that I will obey the laws,legal orders, and decrees promulgated by the duly constituted authorities of the Republic of the Philippines; and that I impose this obligation upon
                    </p>
                    <p style="font-size:16px; text-align: justify; text-indent:30px" >SO HELP ME GOD.</p>
                    <br>
                    <br> 

                  <div style="float:right; font-size:19px ">
                    <center>
                      {$printed_name}
                      <br>
                      (Signature over Printed Name of the Appointee)
                    </center>
                  </div>

                  <div style="clear:both "></div>

<table>
  <tr>
    <td>Government ID:</td>
    <td>{$gov_id_type}</td>
  </tr>
  <tr>
    <td>ID NUmber:</td>
    <td>{$gov_id_num}</td>
  </tr>
  <tr>
    <td>Date Issued:</td>
    <td>{$gov_id_date_issued}</td>
  </tr>
</table>

<br>
<br>
                  <p style="font-size:16px; text-align: justify; text-indent:30px" class="small"> Subscribed and sworn to before me this {$sworn_day} day of {$sworn_month}, {$sworn_year} in {$sworn_address}</p>
<br>
<br>
<div style="float:right; font-size:19px; background: red;">CITY MAYOR</div>

                  <div style="clear:both "></div>

 </div>
HTML;


// printf($html);
// return null;
$mpdf->WriteHTML($html);
$mpdf->Output("CS Form No32.pdf - Oath of Office.pdf", 'I');
