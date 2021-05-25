<?php
    require_once "_connect.db.php";
    $title = "Employee Ledger";
    require_once "header.php";
    require_once "umbra/leaveManagement/ledger_config.php";
    // require_once "umbra/leaveManagement/leave.js";
?>

<div class="ui segment" style="background:#ffeecc;" id="leaveCont">
  <template v-if="Logs.length">       
                <table class="ui compact table" style="font-size: 14px;background:#ffeecc; border: 1px solid #ffeecc">
                    <tr>
                        <td width="10%"><b>NAME:</b></td>
                        <td><?=$fullName ?></td>
                        <td width="15%"><b>FIRST DAY IN SERVICE:</b></td>
                        <td><?=$firstDay ?></td>
                    </tr>
                    <tr>
                        <td><b>POSITION:</b></td>
                        <td><?=$position ?></td>
                    </tr>
                    <tr>
                        <td><b>OFFICE:</b></td>
                        <td><?=$department?><td>
                    </tr>
                </table>
    </div> <hr> <br> 
    <center>
        <div class="header">
            <h2 class="ui header">EMPLOYEE'S LEAVE CARD</h2>
        </div>
    </center>
    
    <table class="ui celled table gwd-table-16du" >
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
 
      <tr  v-for="(log,index) in Logs" :key="index" style="text-align:center">
          <td><span v-html="decodeAppliedDates(log.dateApplied)"></span></td>
          <td>{{showParticulars(log.totalDays)}}</td>
          <td></span></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>{{ log.remarks }}</td>
         
        </tr>
    </table>
</template>
</div>

<script>
    $(document).ready(function() {
        $(".dropdown").dropdown();
    });
    // function approveModal() {
    //   $("#approveModal").modal('show');
    // }
  </script>
   <script src="umbra/leaveManagement/leave.js"></script>
  
<?php
    require_once "footer.php"
   
?>