<?php
require "vendor/autoload.php";
require "_connect.db.php";

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 'format' => 'FOLIO-P',
    'margin_top' => 15,
    'margin_left' => 10,
    'margin_right' => 15,
    'margin_bottom' => 0,
    'margin_footer' => 0,
    'default_font' => 'calibri',
    'width' => 210,
    'height' => 297,
]);

$emp = ($_GET['selectedDat']);
$sql ="SELECT * from `dtrSummary` 
left join `employees` on `dtrSummary`.`employee_id`=`employees`.`employees_id`
left join `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id`
WHERE `dtrSummary`.`dtrSummary_id`='$emp'";     

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$pos = $employee["position"];
$full_name = $employee["firstName"] . ($employee["middleName"] != "." && !empty($employee["middleName"]) ? " " . $employee["middleName"] : "") . " " . $employee["lastName"] . ($employee["extName"] ? " " . $employee["extName"] : "");
$period = strtoupper(date_format(date_create($employee["month"]),"F Y"));
$total = $employee["totalTardy"];
$stmt->close();

$mpdf->Bookmark('Start of the document');

$hrmo = "VERONICA GRACE P. MIRAFLOR";
$hrmo_position = "CGDH-I";
$date = date("F d,Y");
$html = <<< EOD
                <table><tr>
                        <td width="80%"> <img src="form_header.png" width="200px"></td>
                        <td width="40%">
                         <div style="float: right;text-align:right;font-size: 10px; ">
                            <b>OFFICE OF THE HUMAN RESOURCE MANAGEMENT & DEV'T</b><br>
                            New City Hall, Cabcabon, Banga<br>
                            Bayawan City,Negros Oriental, Philippines<br>
                            Fax No.: 430 0222
                            <br>
                            (035) 430 - 0263<br>
                            <u>email : vgpmiraflor@gmail.com</u><br>
                        </div></td>
                      </tr>
                  </table>
                  <br> <br> <br>
                <p  style="font-size: 12px; text-align: justify;  text-indent: -2em; line-height: 1.3">
                    MEMORANDUM NO._______________<br><br>
                    $date
                    <br><br><br>
                    TO:	   &nbsp; &nbsp; $full_name<br>
                          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $pos<br><br>
        
                    RE	:	  <i>Habitual Tardiness</i>
                 <br><br><br>
   
                    This is to inform that per your DTR submitted to the Office of Human Resource Management & Development, you have incurred <b>$total</b> times tardy for the month of <b>$period</b>.
                    <br>
                    <br>
                    Please be reminded that Section 8, Rule XVIII of the Omnibus Rules Implementing Title I, Subtitle A, Book V of the Administrative Code of 1987, as amended, provides that:
                    <br><br>
                   <i>  
                      “SEC. 8. Officers and employees who have incurred tardiness and undertime, regardless of the number of minutes per day, ten (10) times a month for at least two (2) consecutive months during the year or at least two (2) months in a semester shall be subject to disciplinary action.”
                   </i>   

                      <br><br>
                    Section 52, Rule VI of Civil Service Circular No. 19, Series of 1999, on the Revised Uniform Rules on Administrative Cases in the Civil Service, provides:
                        <br><br>
                    Frequent unauthorized tardiness (Habitual Tardiness)<br><br>
                    1st Offense	-	Reprimand<br>
                    2nd Offense	-	Suspension 1-30 days<br>
                    3rd Offense	-	Dismissal<br>

                    
                    <br><br>
                    Hence, this memorandum serves as a stern warning that we will be compelled to impose above penalties should you continue to violate this policy.
                    <br><br>
                    Be guided accordingly.
                    <br> <br>
                    <br> <br>
                  
                    <b>$hrmo</b><br>
                    $hrmo_position <br><br>
                    Received by: _______________________<br>
                    Date Received: _____________________
                    </p>
                
               <br><br>
  </center> 
                  
<br><br><br>
                   <div>
                     <img src="form_footer.png" style= width="1000px">
                   </div>

EOD;


$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->defaultfooterline = 0;

$mpdf->WriteHTML($html);
$mpdf->Output();