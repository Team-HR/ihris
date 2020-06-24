<?php

require "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
// Set default column width
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
// HEADER START
$aRow = 0;
$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()
->setCellValue('A'.($aRow+1), 'CS Form No. 9')
->setCellValue('A'.($aRow+2), 'Series of 2018');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+1))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+2))->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->mergeCells('J'.($aRow+1).':K'.($aRow+2))
->setCellValue('J'.($aRow+1), 'Electronic copy to be submitted to the CSC FO must be in MS Excel format')
->getStyle('J'.($aRow+1).':K'.($aRow+2))->getAlignment()->setWrapText(true);

$spreadsheet->getActiveSheet()->mergeCells('A'.($aRow+3).':K'.($aRow+3))
->setCellValue('A'.($aRow+3), 'Republic of the Philippines')
->getStyle('A'.($aRow+3).':K'.($aRow+3))->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+3).':K'.($aRow+3))->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->mergeCells('A'.($aRow+4).':K'.($aRow+4))
->setCellValue('A'.($aRow+4), 'LGU-BAYAWAN CITY')
->getStyle('A'.($aRow+4).':K'.($aRow+4))->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+4).':K'.($aRow+4))->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->mergeCells('A'.($aRow+5).':K'.($aRow+5))
->setCellValue('A'.($aRow+5), 'Request for Publication of Vacant Positions')
->getStyle('A'.($aRow+5).':K'.($aRow+5))->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+5).':K'.($aRow+5))->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->setCellValue('A'.($aRow+7),'To: CIVIL SERVICE COMMISSION (CSC)');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+7))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+9),'This is to request the publication of the following vacant positions, which are authorized to be filled, at the CGO Bayawan City in the CSC website:');
$spreadsheet->getActiveSheet()->mergeCells('I'.($aRow+11).':K'.($aRow+11))->setCellValue('I'.($aRow+11),'VERONICA GRACE P. MIRAFLOR')->getStyle('I'.($aRow+11).':K'.($aRow+11))->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('I'.($aRow+11).':K'.($aRow+11))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('I'.($aRow+12).':K'.($aRow+12))->setCellValue('I'.($aRow+12),'HRMO IV')->getStyle('I'.($aRow+12).':K'.($aRow+12))->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('I'.($aRow+12).':K'.($aRow+12))->getBorders()->getTop()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->setCellValue('I'.($aRow+14), 'Date:')->getStyle('I'.($aRow+14))->getAlignment()->setHorizontal('right');
$spreadsheet->getActiveSheet()->mergeCells('J'.($aRow+14).':K'.($aRow+14))->setCellValue('J'.($aRow+14), date('F d, yy'));
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+14).':K'.($aRow+14))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+14).':K'.($aRow+14))->getBorders()->getBottom()->setBorderStyle('thin');


// TABLE HEADER START
$spreadsheet->getActiveSheet()->mergeCells('A'.($aRow+16).':A'.($aRow+17))->setCellValue('A'.($aRow+16), 'No.')->getStyle('A'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+16).':A'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+16).':A'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('B'.($aRow+16).':B'.($aRow+17))->setCellValue('B'.($aRow+16), 'Position Title')->getStyle('B'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+16).':B'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+16).':B'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('C'.($aRow+16).':C'.($aRow+17))->setCellValue('C'.($aRow+16), 'Plantilla Item No.')->getStyle('C'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('C'.($aRow+16).':C'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('C'.($aRow+16).':C'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('D'.($aRow+16).':D'.($aRow+17))->setCellValue('D'.($aRow+16), 'Salary/ Job/ Pay Grade')->getStyle('D'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('D'.($aRow+16).':D'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('D'.($aRow+16).':D'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('E'.($aRow+16).':E'.($aRow+17))->setCellValue('E'.($aRow+16), 'Monthly Salary')->getStyle('E'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('E'.($aRow+16).':E'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('E'.($aRow+16).':E'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('F'.($aRow+16).':J'.($aRow+16))->setCellValue('F'.($aRow+16), 'Qualification Standards')->getStyle('F'.($aRow+16).':J'.($aRow+16))->getAlignment()->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('F'.($aRow+16).':J'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('F'.($aRow+16).':J'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('F'.($aRow+17), 'Education')->getStyle('F'.($aRow+17))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('F'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('F'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('G'.($aRow+17), 'Training')->getStyle('G'.($aRow+17))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('G'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('G'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('H'.($aRow+17), 'Experience')->getStyle('H'.($aRow+17))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('H'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('H'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('I'.($aRow+17), 'Eligibilty')->getStyle('I'.($aRow+17))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('J'.($aRow+17), 'Compentency (if applicable)')->getStyle('J'.($aRow+17))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+17))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->mergeCells('K'.($aRow+16).':K'.($aRow+17))->setCellValue('K'.($aRow+16), 'Place of Assignment')->getStyle('K'.($aRow+16))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('K'.($aRow+16).':K'.($aRow+17))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('K'.($aRow+16).':K'.($aRow+17))->getFont()->setBold(true);
// TABLE HEADER END
/*
========================
    THE DATA
========================
*/
$data = array();
$test = array(
    array(
        "position_title"=>"Administrative Officer I (Supply Officer I)",
        "item_no"=>"GSO-10.1",
        "sg"=>"10",
        "monthly_salary"=>"19,208.00",
        "education"=>"Bachelor's Degree",
        "training"=>"None Required",
        "experience"=>"None Required",
        "eligibility"=>"CS-Professional (2nd Level Eligibilty)",
        "competency"=>"None",
        "department"=>"City General Services Office",
    ),
    array(
        "position_title"=>"Administrative Officer I (Supply Officer I)",
        "item_no"=>"GSO-10.2",
        "sg"=>"10",
        "monthly_salary"=>"19, 208.00",
        "education"=>"Bachelor's Degree",
        "training"=>"None Required",
        "experience"=>"None Required",
        "eligibility"=>"CS-Professional (2nd Level Eligibilty)",
        "competency"=>"None",
        "department"=>"City General Services Office",
    ),
    array(
        "position_title"=>"Engineer III",
        "item_no"=>"GSO-22",
        "sg"=>"19",
        "monthly_salary"=>"44,451.00",
        "education"=>"Bachelor's Degree in Engineering relevant to the job",
        "training"=>"8 hours of relevant training",
        "experience"=>"2 years of relevant experience",
        "eligibility"=>"RA 1080",
        "competency"=>"None",
        "department"=>"City General Services Office",
    ),
    array(
        "position_title"=>"Revenue Collection Clerk I",
        "item_no"=>"CTO-24.1",
        "sg"=>"5",
        "monthly_salary"=>"13,909.00",
        "education"=>"Completion of two years studies in college",
        "training"=>"None Required",
        "experience"=>"None Required",
        "eligibility"=>"CS-Subprofessional (1st Level Eligibilty)",
        "competency"=>"None",
        "department"=>"City Treasurer's Office",
    ),
    array(
        "position_title"=>"Revenue Collection Clerk I",
        "item_no"=>"CTO-24.3",
        "sg"=>"5",
        "monthly_salary"=>"13,909.00",
        "education"=>"Completion of two years studies in college",
        "training"=>"None Required",
        "experience"=>"None Required",
        "eligibility"=>"CS-Subprofessional (1st Level Eligibilty)",
        "competency"=>"None",
        "department"=>"City Treasurer's Office",
    ),
    array(
        "position_title"=>"Medical Officer IV",
        "item_no"=>"CHO-8.2",
        "sg"=>"23",
        "monthly_salary"=>"75,359.00",
        "education"=>"Doctor of Medicine",
        "training"=>"4 hours of relevant training",
        "experience"=>"1 year of relevant experience",
        "eligibility"=>"RA 1080",
        "competency"=>"None",
        "department"=>"City Health Office",
    ),
    array(
        "position_title"=>"Engineer III",
        "item_no"=>"CEO-30",
        "sg"=>"19",
        "monthly_salary"=>"44,451.00",
        "education"=>"Bachelor's Degree in  Engineering relevant to the job",
        "training"=>"8 hours of relevant training",
        "experience"=>"2 years of relevant experience",
        "eligibility"=>"RA 1080",
        "competency"=>"None",
        "department"=>"City Engineering Office",
    ),


);
$data = $test;

$no = 0;
$aRow = $aRow+17;

$cols = array('A','B','C','D','E','F','G','H','I','J','K');
$fields = array('no','position_title','item_no','sg','monthly_salary','education','training','experience','eligibility','competency','department');

foreach ($data as $value) {
    $no++;
    foreach ($cols as $i => $col) {
        if($i === 0){
            $spreadsheet->getActiveSheet()->setCellValue($col.($aRow+$no), $no)->getStyle($col.($aRow+$no))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($col.($aRow+$no))->getBorders()->getOutline()->setBorderStyle('thin'); 
        } else {
            $spreadsheet->getActiveSheet()->setCellValue($col.($aRow+$no), $value[$fields[$i]])->getStyle($col.($aRow+$no))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($col.($aRow+$no))->getBorders()->getOutline()->setBorderStyle('thin'); 
        }
    }
    
    // $spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+$no), $value["position_title"])->getStyle('B'.($aRow+$no))->getAlignment()->setHorizontal('left')->setVertical('center')->setWrapText(true);
    // $spreadsheet->getActiveSheet()->getStyle('B'.($aRow+$no))->getBorders()->getOutline()->setBorderStyle('thin');
    // $spreadsheet->getActiveSheet()->setCellValue('C'.($aRow+$no), $value["item_no"])->getStyle('C'.($aRow+$no))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
    // $spreadsheet->getActiveSheet()->getStyle('C'.($aRow+$no))->getBorders()->getOutline()->setBorderStyle('thin');
}

// Column widths
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(41);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Sheet1');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="test.xlsx"');
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
