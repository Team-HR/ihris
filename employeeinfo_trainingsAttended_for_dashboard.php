<?php
require_once "_connect.db.php";
$employees_id = $_GET["employees_id"];
?>
  <table class="ui very basic celled table compact" style="font-size: 12px">
    <thead>
    <tr>
        <th></th> 
        <th>Developmental Intervention</th>
        <th>Date</th>
        <th>No. of Hours</th>
        <th>Venue</th>
    </tr>
    </thead>
    <tbody id="table-body"></tbody> 
  </table>
  
  <script type="text/javascript">
      jQuery(document).ready(function($) {
            $(getRows);
      });

      function getRows(){
        $.post('employeeinfo_trainingsAttended_proc.php', {'getTrainingRowsDash': true , 'employees_id': <?=$employees_id?>}, function(data, textStatus, xhr) {
            if (data) {
                json = $.parseJSON(data);
                $('#table-body').html(json);    
            }
            
        });
      }
  </script>
