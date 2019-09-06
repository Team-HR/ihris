<?php
require('fpdf.php');
require '../_connect.db.php';

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table
function BasicTable($header, $data)
{
    // Header
    // $width = 30;

    // Column widths
    $w = array(15, 40, 40, 10, 10, 15);

    // foreach($header as $col)
    //     $this->Cell($width,7,$col,1);
    // $this->Ln();

    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();


    // Data

    foreach($data as $row)
    {
        $row[0] = "Ññ";
        // foreach($row as $col)
        //     $this->Cell($width,6,$col,1);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],6,$row[$i],1);
        $this->Ln();
    }

}

// Better table
function ImprovedTable($header, $data)
{
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('ID', 'Last Name', 'First Name', 'M.','Ext.','Gender');
// Data loading
$data = $pdf->LoadData('countries.txt');
// var_dump($data);
// print_r($data);
// foreach ($data as $value) {
//     print_r($value);
//     echo "<br>";
// }

$sql = "SELECT * FROM `employees` ORDER BY `lastName` ASC";
$result = $mysqli->query($sql);
$data = array();
while ($row = $result->fetch_assoc()) {

    $employees_id = $row["employees_id"];
    $lastName = mb_convert_case($row["lastName"],MB_CASE_TITLE, "UTF-8");
    $firstName = mb_convert_case($row["firstName"],MB_CASE_TITLE, "UTF-8");
    $middleName = mb_convert_case($row["middleName"],MB_CASE_TITLE, "UTF-8");
    $extName = $row["extName"];
    $gender = mb_convert_case($row["gender"],MB_CASE_TITLE, "UTF-8");
    if ($gender) {
        $gender = $gender[0];
    }

    $data_push = array($employees_id,$lastName,$firstName,$middleName[0].".",$extName,$gender);
    array_push($data, $data_push);
}

$pdf->SetFont('Times','',12);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
// $pdf->AddPage();
// $pdf->ImprovedTable($header,$data);
// $pdf->AddPage();
// $pdf->FancyTable($header,$data);
$pdf->Output();
?>