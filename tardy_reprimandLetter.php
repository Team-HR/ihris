<?php
    $title = "Reprimand Letter";
    require_once "header.php";

    $emp = ($_GET['selectedDat']);

    $sql ="SELECT * from `dtrSummary` 
    left join `employees` on `dtrSummary`.`employee_id`=`employees`.`employees_id`
    left join `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id`
    WHERE `dtrSummary`.`dtrSummary_id`='$emp'";   

    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    $hrmo = "VERONICA GRACE P. MIRAFLOR";
    $hrmo_pos = "CGDH - I";
    ?>

    
<div id="">
    <div class="ui segment"  style="margin:auto;max-width:50%;min-width:1080px;">
           <div> <img src="form_header.png" style="width:200px; height:100px; float:left; margin-left:50px">
                  </div>         
                  <div style="float: right;text-align:right;font-size: 12px; ">
                            <b>OFFICE OF THE HUMAN RESOURCE MANAGEMENT & DEV'T</b><br>
                            New City Hall, Cabcabon, Banga<br>
                            Bayawan City,Negros Oriental, Philippines<br>
                            Fax No.: 430 0222
                            <br>
                            (035) 430 - 0263<br>
                            <u>email : vgpmiraflor@gmail.com</u><br>
                  </div>            

                  <div style="clear:both"></div>

<br><br><br><br>
                  
            <form class="ui form" style="font-size:18px">

              <?php echo  date("F d, Y") ?> 
              
<br><br><br><br>

              TO:	   &nbsp; &nbsp;  <?=$row['firstName']?> <?=$row['middleName']?> <?=$row['lastName']?><br>
                     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <?=$row['position']?><br><br><br>
        
              RE	: &nbsp; &nbsp; 	 
                             <i>Reprimand due to Habitual Tardiness</i>
<br><br><br><br>

                  <div style="margin:10px; line-height: 1.5">
                        This is to inform that per your DTR submitted to the Office of Human Resource Management & Development, you have incurred <b>$total</b> times tardy for the month of <b>$period</b>.
                       <i  class=" green edit icon noprint">       
                      </i>
                  </div>

                <!-- <template >
                    <div class="field">
                          <textarea width="100%" height="5%" v-model="body">
                          </textarea>
                    </div>
                </template> -->
<br>
                <div style="margin:10px;font-size:18px;line-height:1.5">
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
                </div>
                
              <div style="margin-top:30px;line-height: 2">  
                  Hence, this memorandum serves as a stern warning that we will be compelled to impose above penalties should you continue to violate this policy. 
                      <i  class=" green edit icon noprint">       
                      </i>
              </div>
            
<br><br>
                 Be guided accordingly.
<br><br><br><br><br><br>
                    <b><?php echo $hrmo?> </b><br>
                    <?php echo $hrmo_pos?><br><br><br><br>
                    Received by: _______________________<br>
                    Date Received: _____________________
                    </p>
            </form>
             
            <br>   
            
            <div>
                     <img src="form_footer.png" style="width:1020px; height:100px">
            </div>         
</div>

<?php
    require_once "footer.php";
?>