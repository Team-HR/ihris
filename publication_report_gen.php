<?php
require "vendor/autoload.php";

$date_of_publication = $_GET["date_of_publication"];
$date_of_deadline = $_GET["date_of_deadline"];

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
// Set default column width
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(115);


// HEADER START
$aRow = 0;
$spreadsheet->setActiveSheetIndex(0);
$spreadsheet->getActiveSheet()
->setCellValue('A'.($aRow+1), 'CS Form No. 9')
->setCellValue('A'.($aRow+2), 'Series of 2018');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+2))->getFont()->setBold(false)->setItalic(false)->setSize(8);
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+1))->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+2))->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->mergeCells('J'.($aRow+1).':K'.($aRow+2))
->setCellValue('J'.($aRow+1), 'Electronic copy to be submitted to the CSC FO must be in MS Excel format')
->getStyle('J'.($aRow+1).':K'.($aRow+2))->getAlignment()->setWrapText(true)->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+1).':K'.($aRow+2))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('J'.($aRow+1).':K'.($aRow+2))->getFont()->setBold(false)->setItalic(true)->setSize(8);

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
$spreadsheet->getActiveSheet()->mergeCells('J'.($aRow+14).':K'.($aRow+14))->setCellValue('J'.($aRow+14), date("F d, Y", strtotime($date_of_publication)));
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

require "_connect.db.php";
$sql = "SELECT-- *
positiontitles.position,
positiontitles.functional,
plantillas.item_no,
positiontitles.salaryGrade AS salary_grade,
plantillas.step,
plantillas.`schedule`,
qualification_standards.education,
qualification_standards.experience,
qualification_standards.training,
qualification_standards.eligibility,
qualification_standards.competency,
qualification_standards.others,
department.department 
FROM
	plantillas
	LEFT JOIN positiontitles ON plantillas.position_id = positiontitles.position_id
	LEFT JOIN qualification_standards ON qualification_standards.position_id = positiontitles.position_id
	LEFT JOIN department ON plantillas.department_id = department.department_id 
WHERE
	`plantillas`.`id` IN ( SELECT `publications`.`plantilla_id` FROM publications ) 
	AND plantillas.incumbent IN ('',NULL)
	AND plantillas.abolish IN ('',NULL,'No')
ORDER BY
	positiontitles.position ASC";

// $data = $test;

$result = $mysqli->query($sql);
while($row = $result->fetch_assoc())
{
    $data[] = array(
        "position_title"=>$row["position"],
        "item_no"=>$row["item_no"],
        "sg"=>$row["salary_grade"],
        "monthly_salary"=>getMonthlySalary($mysqli,$row["salary_grade"],$row["step"],$row["schedule"]),
        "education"=>$row["education"],
        "training"=>$row["training"],
        "experience"=>$row["experience"],
        "eligibility"=>$row["eligibility"],
        "competency"=> "None Required",//$row["competency"],
        "department"=>$row["department"]
    );
}

function getMonthlySalary($mysqli,$sg,$step,$schedule) {
    $monthly_salary = 0;
    if(empty($sg) || empty($step) || empty($schedule)) return "No SG/STEP/SCHED provided in plantilla";
    $sql = "SELECT id FROM `ihris_dev`.`setup_salary_adjustments` WHERE schedule = ? AND active = '1'";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i',$schedule);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $parent_id = 0;
    $parent_id = $row["id"];
    $stmt->close();
    if (empty($parent_id)) return false;
    $sql = "SELECT monthly_salary FROM `ihris_dev`.`setup_salary_adjustments_setup` WHERE parent_id = ? AND salary_grade = ? AND step_no = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii',$parent_id,$sg,$step);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();  
    $monthly_salary = $row["monthly_salary"];
    return $monthly_salary?number_format($monthly_salary,2,'.',','):"No SG/STEP/SCHED matched";
}

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
            $spreadsheet->getActiveSheet()->getStyle($col.($aRow+$no))->getFont()->setBold(true);
        } else {
            $spreadsheet->getActiveSheet()->setCellValue($col.($aRow+$no), $value[$fields[$i]])->getStyle($col.($aRow+$no))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle($col.($aRow+$no))->getBorders()->getOutline()->setBorderStyle('thin'); 
        }
    }
}

$aRow = $aRow+$no+1;
$spreadsheet->getActiveSheet()->mergeCells('A'.($aRow).':K'.($aRow))->setCellValue('A'.($aRow), '*** NOTHING FOLLOWS ***')->getStyle('A'.($aRow))->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow).':K'.($aRow))->getBorders()->getOutline()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow).':K'.($aRow))->getFont()->setBold(true);


$richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
$text = $richText->createTextRun('              ');
$text = $richText->createTextRun("Interested and qualified applicants should signify their interest in writing. Attach the following documents to the application letter and send to the address below not later than");
$text->getFont()->setSize(11);
$spreadsheet->getActiveSheet()->setCellValue('A'.($aRow+2), $richText);

$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+3), date("F d, Y", strtotime($date_of_deadline)))->getStyle('B'.($aRow+3))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+3))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+3))->getFont()->setSize(12)->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+3))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('ffff00');

$requirements = array(
                    "1. Job Application Form (available at the HR Office)",
                    "2. Application Letter",
                    "3. Fully accomplished Personal Data Sheet (PDS) with  work experience sheet and recent passport-sized ID picture (CS Form No. 212, Revised 2017, which can be downloaded at www.csc.gov.ph);",
                    "4. Performance rating  in the last rating period (if applicable);",
                    "5. Photocopy of certificate of trainings (if applicable);",
                    "6. Photocopy of certificate of eligibility/rating/license; and",
                    "7. Photocopy of Transcript of Records/Diploma (if applicable)."
);

$aRow = $aRow+3;

for($i=0; $i < count($requirements); $i++){
    $spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+$i+1), $requirements[$i]);
}

$row = $aRow+8;
$spreadsheet->getActiveSheet()->mergeCells('I'.($row).':K'.($row))->setCellValue('I'.($row), 'LGU Bayawan City upholds Equal Employment')->getStyle('I'.($row))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getBorders()->getLeft()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getBorders()->getTop()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getBorders()->getRight()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getFont()->setSize(14)->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getFont()->setName('Calibri');

$row = $aRow+9;
$spreadsheet->getActiveSheet()->mergeCells('I'.($row).':K'.($row))->setCellValue('I'.($row), 'Opportunity Principle')->getStyle('I'.($row))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getBorders()->getLeft()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getBorders()->getRight()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getFont()->setSize(14)->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row))->getFont()->setName('Calibri');

$row = $aRow+10;
$spreadsheet->getActiveSheet()->mergeCells('I'.($row).':K'.($row+8))->setCellValue('I'.($row), "\n        The City Government of Bayawan, in its pursuit of effective governance, commits to equality of opportunity. It will not discriminate in recuitment or policy administration on the basis of age, sex, religion, disability, sexual orientation or gender identity or expression, enthnicity and political affiliation.")->getStyle('I'.($row))->getAlignment()->setHorizontal('left')->setVertical('top')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row+8))->getBorders()->getLeft()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row+8))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row+8))->getBorders()->getRight()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row+8))->getFont()->setSize(14)->setBold(false);
$spreadsheet->getActiveSheet()->getStyle('I'.($row).':K'.($row+8))->getFont()->setName('Calibri');

$aRow = $aRow+12;

$richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
$text = $richText->createTextRun('QUALIFIED APPLICANTS');
$text->getFont()->setBold(true);
$text = $richText->createTextRun(" are advised to hand in or send through courier/email their application to:");
$spreadsheet->getActiveSheet()->setCellValue('A'.$aRow, $richText);

$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+2), 'VERONICA GRACE P. MIRAFLOR')->getStyle('B'.($aRow+2))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+2))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+2))->getFont()->setSize(11)->setBold(true);
$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+3), 'HRMO IV')->getStyle('B'.($aRow+3))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+3))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+4), 'Cabcabon, Brgy. Banga, Bayawan City')->getStyle('B'.($aRow+4))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+4))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->setCellValue('B'.($aRow+5), 'vgpmiraflor@gmail.com')->getStyle('B'.($aRow+5))->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
$spreadsheet->getActiveSheet()->getStyle('B'.($aRow+5))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->setCellValue('A'.($aRow+7), 'APPLICATIONS WITH INCOMPLETE DOCUMENTS SHALL NOT BE ENTERTAINED.');
// $spreadsheet->getActiveSheet()->getStyle('A'.($aRow+7))->getBorders()->getBottom()->setBorderStyle('thin');
$spreadsheet->getActiveSheet()->getStyle('A'.($aRow+7))->getFont()->setSize(11)->setBold(true);

// Column widths
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(41);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);


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
header('Content-Disposition: attachment;filename="Publication_'.date("F-d-Y", strtotime($date_of_publication)).'.xlsx"');
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