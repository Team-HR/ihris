<?php
require "vendor/autoload.php";

$date = date('f d, Y');
$date_of_deadline = $_GET["date_of_deadline"];

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
// Set default column width
// $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(115);

// TABLE HEADER END
/*
========================
    THE DATA
========================
*/
$data = array();

require "_connect.db.php";
require "./libs/NameFormatter.php";

$filters = "";
$sql = construct_sql($filters);
$result = $mysqli->query($sql);
$counter = 0;
$num_rows = $result->num_rows;

$sheet = $spreadsheet->getActiveSheet();
// HEADER START
$sheet->setCellValue('B1', 'FULLNAME')->getStyle('B1')->getFont()->setBold(true);
$sheet->setCellValue('C1', 'STATUS')->getStyle('C1')->getFont()->setBold(true);
$sheet->setCellValue('D1', 'GENDER')->getStyle('D1')->getFont()->setBold(true);
$sheet->setCellValue('E1', 'DEPARTMENT')->getStyle('E1')->getFont()->setBold(true);
$sheet->setCellValue('F1', 'POSITION')->getStyle('F1')->getFont()->setBold(true);
// HEADER END
$n = 2;
while ($row = $result->fetch_assoc()) {
    $row_index = $n++;
    $name = new NameFormatter($row["firstName"], $row["lastName"], $row["middleName"], $row["extName"]);
    $sheet->setCellValue('B' . $row_index, mb_convert_case($name->getFullName(), MB_CASE_UPPER, 'UTF-8'));
    $status = $row["status"];
    $sheet->setCellValue('C' . $row_index, $status);
    if ($status === "INACTIVE") {
        $spreadsheet->getActiveSheet()->getStyle('C' . $row_index)
        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
    }
    $sheet->setCellValue('D' . $row_index, $row["gender"]);
    $sheet->setCellValue('E' . $row_index, $row["department"]);
    $sheet->setCellValue('F' . $row_index, $row["position"]);
}



// Column widths
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30.7);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(54);


$spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
$spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.14);
$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.12);
$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.18);
$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.12);

// $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea('A1:E5,G4:M20');

$spreadsheet->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 17);
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Sheet1');
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Employee_list' . date("F-d-Y", strtotime($date)) . '.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;

function construct_sql($filters)
{
    $status_arr = array();
    $gender_arr = array();
    $type_arr = array();
    $nature_arr = array();
    $dept_arr = array();

    $filters_sql = '';

    if ($filters) {
        foreach ($filters as $value) {
            $value_arr = explode("=", $value);
            $index = $value_arr[0];
            $el = $value_arr[1];
            if ($index === "status") {
                array_push($status_arr, $el);
            } elseif ($index === "gender") {
                array_push($gender_arr, $el);
            } elseif ($index === "type") {
                array_push($type_arr, $el);
            } elseif ($index === "nature") {
                array_push($nature_arr, $el);
            } elseif ($index === "dept_id") {
                array_push($dept_arr, $el);
            }
        }

        $sql_arr = array();
        if ($status_arr) {
            array_push($sql_arr, "employees.status IN(" . filter_val($status_arr) . ")");
        }
        if ($gender_arr) {
            array_push($sql_arr, "employees.gender IN(" . filter_val($gender_arr) . ")");
        }
        if ($type_arr) {
            array_push($sql_arr, "employees.employmentStatus IN(" . filter_val($type_arr) . ")");
        }
        if ($nature_arr) {
            array_push($sql_arr, "employees.natureOfAssignment IN(" . filter_val($nature_arr) . ")");
        }
        if ($dept_arr) {
            array_push($sql_arr, "employees.department_id IN(" . filter_val($dept_arr) . ")");
        }

        $i = 0;
        $filters_sql = " WHERE ";
        foreach ($sql_arr as $value) {
            $i++;
            $filters_sql .= $value;
            if (count($sql_arr) !== $i) {
                $filters_sql .= " AND ";
            }
        }
    }

    $sql = "SELECT * FROM `employees` LEFT JOIN `department` ON employees.department_id = department.department_id LEFT JOIN `positiontitles` ON employees.position_id = positiontitles.position_id 
	$filters_sql
	ORDER BY `lastName` ASC";


    return $sql;
}
