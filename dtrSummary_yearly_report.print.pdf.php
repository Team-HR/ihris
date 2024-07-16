<?php
require_once "vendor/autoload.php";
require_once "dtrSummary_yearly_report_config.php";

$year = $_GET["year"];
$employee_ids = $_GET["ids"];
$employee_ids = explode(",", $employee_ids);
if (count($employee_ids) < 1 || !$year) return null;
$items = [];
foreach ($employee_ids as $employee_id) {
    $items[] = get_employee_dtr($mysqli, $employee_id, $year);
}

// $json_items = json_encode($items, JSON_PRETTY_PRINT);
// echo "<pre>$json_items</pre>";
// return false;

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 'format' => 'A4-L',
    'margin_top' => 5,
    'margin_left' => 3,
    'margin_right' => 3,
    'margin_bottom' => 5,
    'margin_footer' => 1,
    'default_font' => 'helvetica'
]);

$mpdf->Bookmark('Start of the document');
$html = <<<EOD
    <style>
        body {
            font-size: 9px;
        }
        table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            border: 1px solid black;
        }
        table td {
            border: 1px solid black;
            padding-left: 5px;
        }
        .no {
            text-align: center;
        }
    </style>
    <h1 style="text-align:center;">DTR Report for the year $year</h1>
    <table> 
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>January</th>
                <th>February</th>
                <th>March</th>
                <th>April</th>
                <th>May</th>
                <th>June</th>
                <th>July</th>
                <th>August</th>
                <th>September</th>
                <th>October</th>
                <th>November</th>
                <th>December</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
    EOD;

foreach ($items as $key => $item) {
    $no = $key + 1;
    $html .= <<<EOD
    <tr>
        <td class="no">$no</td>
        <td>$item[name]</td>
EOD;

    for ($i = 0; $i < 12; $i++) {
        $month = $item["months"][$i];
        $html .= <<<EOD
        <td>
            Tardy(n): $month[totalTardy]
            <br>
            UT: $month[totalMinsUndertime]
            <br>
            Absences: 
            <br>
            $month[remarks]
        </td>
EOD;
    }

    $html .= <<<EOD
        <td></td>
    </tr>
EOD;
}


$html .= <<<EOD
        </tbody>
    </table>
    EOD;

$mpdf->WriteHTML($html);
$mpdf->Output("DTR Report for the year $year.pdf", 'I');
