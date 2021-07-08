<?php
    require_once "_connect.db.php";
    $title = "Employee Ledger";
    require_once "header.php";

   $employees_id = $_GET["employees_id"];


   $sql = "SELECT * FROM `employees` LEFT JOIN `department` on `employees`.`department_id`=`employees`.`department_id`
                                    LEFT JOIN `positiontitles` on `employees`.`position_id`=`positiontitles`.`position_id`
                                     WHERE `employees_id` = '$employees_id'";
   $result = $mysqli->query($sql);
   $row = $result->fetch_assoc();
   $lastName = $row["lastName"];
   $firstName = $row["firstName"];
   $middleName = $row["middleName"];
   $extName = $row["extName"];
   $dept = $row["department"];
   $employment_date = $row["dateActivated"];
   $pos = $row["position"];
   $func = $row["functional"];
   

   $position =  $pos . " | " . $func;
   $fullname = $lastName . ", " . $firstName . " $middleName" . " " . $extName;
?>


<center>
  <div id="ledger" style="background:white">
<br>
      <strong>
        <?php echo $fullname ?> <br>
        <?php echo $dept ?> <br>
          <?php echo $position ?> <br>
        <?php echo $employment_date ?> <br>
      
      </strong>
<br>
<br>

<div class="ui large header">Employee's Leave Card</div>
    
    <table class="ui very small compact structured celled table" style="width:1080px">
         <thead>
            <tr  style=" text-align:center">
                <th rowspan="2">PERIOD</th>
                <th rowspan="2">PARTICULARS</th>
                <th colspan="4">VACATION LEAVE</th>
                <th colspan="4">SICK LEAVE</th>
                <th rowspan="2">DATE AND ACTION TAKE <br> ON APPL. FOR LEAVE</th>
            </tr>
            <tr style="font-size:11px; text-align:center" >
                <th>EARNED</th>
                <th>ABS.UND.W/P</th>
                <th>BAL</th>
                <th>ABS.UND.WOP</th>
                <th>EARNED</th>
                <th>ABS.UND.W/P</th>
                <th>BAL</th>
                <th>ABS.UND.WOP</th>
            </tr>
      </thead>
        <tbody>

 <template v-if="ledgers.length != 0">
        <tr v-for="(ledger,i) in ledgers" :key="i">
             <td>
                <template v-if="ledger.leaveType == 'Monetization'">
                {{ ledger.mone_applied}}
                </template>
                <template v-else>
                <span v-html="decodeAppliedDates(ledger.dateApplied)"></span>
                </template>
            </td>
             <td><span v-html="showParticulars(ledger.totalDays)"></span>  ( {{ledger.leaveType}}{{ledger.sp_type}} )</td>
             <td></td>
             <td>
             
                {{ ledger.vl_deductions}}
               
             <td></td>
             <td></td>
             <td></td>
             <td>  
         
                {{ ledger.sl_deductions}}
                
             <td></td>
             <td></td>
             <td>{{ledger.remarks}}</td>
        </tr>
        </tr>
        </template>
        <template  v-else>
            <tr class="center aligned" style="color:lightgrey">
                <td colspan="9">-- No leave logged yet --</td>
            </tr>
        </template>
    
        </tbody>
    </table>
    </center> 
</div>
</div>
<script src="umbra/leaveManagement/ledger.js"></script>