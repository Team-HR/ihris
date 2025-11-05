<?php
ini_set("pcre.backtrack_limit", "5000000");

// Include the main TCPDF library (search for installation path).
require_once('../TCPDF-master/tcpdf.php');
require "../vendor/autoload.php";
require_once('../_connect.db.php');
require "../libs/models/Employee.php";

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$ids = $_GET['ids'];
$ids = explode(",", $ids);
$pages = [];

foreach ($ids as $id) {
  $sql = "SELECT * FROM notice_of_salary_adjustment_records WHERE id = '$id'";
  $res = $mysqli->query($sql);
  if ($row = $res->fetch_assoc()) {
    $row['nosa'] = null;
    //get nosa info start
    $sql2 = "SELECT * FROM notice_of_salary_adjustments WHERE id = '$row[notice_of_salary_adjustment_id]'";
    $res2 = $mysqli->query($sql2);
    if ($row2 = $res2->fetch_assoc()) {
      $row2['date'] = dateToString($row2['date']);
      $row2['lbc_date'] = dateToString($row2['lbc_date']);
      $row2['exec_order_date'] = dateToString($row2['exec_order_date']);
      $row2['date_effective'] = dateToString($row2['date_effective']);
      $row2['default_salary_date'] = dateToString($row2['default_salary_date']);
      $row['nosa'] = $row2;
    }
    //get nosa info end

    $row['honorific'] = mb_convert_case($row['honorific'], MB_CASE_UPPER);
    $row['pronoun'] = "";
    if ($row['honorific'] == 'MR.') {
      $row['pronoun'] = "Sir:";
    } elseif ($row['honorific'] == 'MS.') {
      $row['pronoun'] = "Ma'am:";
    }

    $row['new_salary'] = number_format($row['new_salary'], 2, '.', ',');
    $row['old_salary'] = number_format($row['old_salary'], 2, '.', ',');

    $row['difference'] = $row['new_salary'] - $row['old_salary'];
    $row['difference'] = number_format($row['difference'], 2, '.', ',');
    $row['full_name'] = mb_convert_case($row['full_name'], MB_CASE_UPPER);
    $pages[] = $row;
  }
}

// echo "<pre>";
// echo print_r($pages);
// echo "</pre>";

// return false;

$mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
    __DIR__ . '/../assets/fonts', // folder where Arial.ttf is located
  ]),
  'fontdata' => $fontData + [
    'arial' => [
      'R' => 'ARIAL.TTF',     // Regular
      'B' => 'ARIALBD.TTF',   // Bold
      'I' => 'ARIALI.TTF',    // Italic
      'BI' => 'ARIALBI.TTF',  // Bold Italic
    ]
  ],
  'format' => 'A4',
  'margin_top' => 3,
  'margin_left' => 5,
  'margin_right' => 5,
  'margin_bottom' => 3,
  'margin_header' => 0,
  'margin_footer' => 0,
  'default_font' => 'arial',
  'default_font_size' => 11
]);

$html = "";

foreach ($pages as $key => $page) {
  if ($key > 0) {
    $html .= <<<HTML
    <pagebreak />
    HTML;
  }
  $html .= <<<HTML
   <div style="text-align:center; margin-bottom: 20px;">
      <img src="../assets/images/forms/nosa/nosa_header_2025.jpg" width="100%" height="120"/>
  </div>
  <div style="margin-left: 15mm; margin-right: 10mm;">
    <div style="text-align:right;"><b>ANNEX B-2</b></div>
    <br>
    <div style="text-align: center; font-family: Arial, sans-serif;"><b>NOTICE OF SALARY ADJUSTMENT</b></div>
    <br>
    <div style="text-align:right;">{$page['nosa']['date']}</div>
    <br>
    <table>
        <tr>
          <td style="border-bottom: 1px solid black"><b>$page[honorific] $page[full_name]</b></td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid black">Casual</td>
        </tr>
        <tr>
          <td style="border-bottom: 1px solid black">LGU, Bayawan City</td>
        </tr>
    </table>
    <br><br>
      $page[pronoun]
    <br><br>
    <p style="text-indent: 15mm; line-height: 1.5; text-align: justify;">Pursuant to Local Budget Cricular No. <u>{$page['nosa']['lbc_no']}</u> dated <u>{$page['nosa']['lbc_date']}</u>, implementing Executive Order No. {$page['nosa']['exec_order_no']}, dated {$page['nosa']['exec_order_date']}, your salary/daily wage is hereby adjusted effective <b>{$page['nosa']['date_effective']}</b>, as follows:</p>
  
    <table style="margin-left: 10mm;">
      <tr>
        <td style="vertical-align: top;line-height: 1.5;">1.</td>
        <td style="width: 120mm; line-height: 1.5; text-align: justify;">Monthly basic salary/Daily wage rate, <br>under the new Salary Schedule; SG 1 <br> <br> <br></td>
        <td style="vertical-align: top;line-height: 1.5;">P<u>{$page['new_salary']}</u></td>
      </tr>
      <tr>
        <td style="vertical-align: top;line-height: 1.5;">2.</td>
        <td style="width: 120mm; line-height: 1.5; text-align: justify;">Actual monthly basic salary/Daily wage rate <br>as of {$page['nosa']['default_salary_date']}; SG 1 <br> <br> <br></td>
        <td style="vertical-align: top;line-height: 1.5;">P<u>{$page['old_salary']}</u></td>
      </tr>
      <tr>
        <td style="vertical-align: top;line-height: 1.5;">3.</td>
        <td style="width: 120mm; line-height: 1.5; text-align: justify;">Monthly salary/daily wage adjustment <br>effective {$page['nosa']['default_salary_date']}; (1-2) <br> <br> </td>
        <td style="vertical-align: top;line-height: 1.5;">P<u>{$page['difference']}</u></td>
      </tr>
    </table>
    
    <p style="text-indent: 10mm; line-height: 1.5; text-align: justify;">It is understood that this salary/daily wage adjustment is subject to usual accounting and auditing rules and regulations, and to appropriate re-adjustment and refund if found not in order.</p>
    

    <table>
      <tr>
        <td style="width:110mm;"></td>
        <td>Very truly yours, <br><br><br><br><br></td>
      </tr>
      <tr>
        <td></td>
        <td style="text-align: center;">
          <div><b>{$page['nosa']['city_mayor']}</b></div>
          <div>City Mayor</div>
        </td>
      </tr>
    </table>


    <table style="font-size: 10pt;">
      <tr>
        <td>Position Title</td>
        <td>:</td>
        <td style="border-bottom: 1px solid black; width: 20mm;">Casual</td>
      </tr>
      <tr>
        <td>Salary Grade</td>
        <td>:</td>
        <td style="border-bottom: 1px solid black; text-align: center;">{$page['nosa']['default_salary_grade']}</td>
      </tr>
    </table>

    <br>

    <table style="font-size: 9pt;" cellspacing="0">
      <tr>
        <td style="width: 15mm; vertical-align:top;">cc:</td>
        <td style="vertical-align:top;">-GSIS <br>-CAO, LGU Bayawan <br>-CBO, LGU Bayawan <br>-CTO, LGU Bayawan</td>
      </tr>
    </table>
  </div>
  <div style="position: fixed; bottom: 0; left: 0; right: 0; text-align:center;">
    <img src="../assets/images/forms/nosa/nosa_footer_2025.png" height="100" style="width: 2000px;"/>
  </div>
HTML;
}
// /home/administrator/ohrmd_docker_apps/htdocs/ihris/assets/images/forms/nosa/nosa_header.jpg



$mpdf->WriteHTML($html);
$file_title = "NOSA (Casual)";
$mpdf->Output($file_title . ".pdf", 'I');

function getData($mysqli, $id)
{
  $data = [];
  $employee = new Employee;

  return $data;
}


function dateToString($date)
{
  $date = new DateTime($date);
  $dateString = $date->format("F j, Y");
  return $dateString; // Example: 2025-09-10 12:34:56
}
