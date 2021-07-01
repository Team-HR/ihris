<?php
      
      $title = "Add Leave Credits";
      require_once "header.php";  
?>
<div class="ui segment">
<div id="addModal" class="ui mini modal">
    <div class="header">
        Add Leave Credits
    </div>
    <div class="content">
    <div class="ui form">
    <div class="field">
             <!-- <div class="field">
                    <label>Employee:</label>
                    <input id="employees_id" type="number"> 
                </div> -->
                <div class="field">
                    <label>As of:</label>
                    <input id="as_of" type="date" >
                </div>
                <div class="field">
                    <label>Vacation Leave Credits:</label>
                    <input id="vl" type="number" placeholder="Vacation leave credits">
                </div>
                <div class="field">
                    <label>Sick Leave Credits:</label>
                    <input id="sl" type="number" placeholder="Sick leave credits">
                </div>
               
    </div>        
    </div>
    </div>
    <div class="actions">
        <div class="ui deny button mini">
        Cancel
        </div>
        <div class="ui approve blue right labeled icon button mini">
        Add
        <i class="checkmark icon"></i>
        </div>
    </div>
</div>


<center><div class="ui large header">Add Leave Credits</div>

<div class="ui icon fluid input" style="width: 300px;">
    <input id="search_name" type="text" placeholder="Search...">
    <i class="search icon"></i>
</div>

 <table id="leaveCredits_table"  class="ui celled table" style="width:800px">
    <thead>
        <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Employee Name</th>
        <th colspan="4">Leave Credits Balance</th>
        </tr>
        <tr style="text-align:center">
      
        <th>Vacation</th>
        <th>Sick</th>        
        <th>Date earned</th>
        <th>Options</th>
        </tr>
        
    </thead>
    <tbody>
    <?php 
        $sql = "SELECT * FROM `employees`  LEFT JOIN  `lm_earnings` on `employees`.`employees_id`=`lm_earnings`.`emp_id` ORDER BY `lastName` ASC";
        $result = $mysqli->query($sql);
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
            $as_of = $row["as_of"];
            $employees_id = $row["employees_id"];
            $lastName = $row["lastName"];
            $firstName = $row["firstName"];
            $vl = $row["vl"];
            $sl = $row["sl"];
            $counter++;
            if (!$row['vl']) {
              $vl = "<i style='color:grey; font-size: 10px'>No Available Bal.</i>";
            }
            if (!$row['sl']) {
              $sl = "<i style='color:grey; font-size: 10px'>No Available Bal.</i>";
            } if (!$row['as_of']) {
              $as_of = "<i style='color:grey;font-size: 10px'>---- | -- | --</i>";
            }

        ?>
        <tr>
            <td><?php  echo  $counter ?></td>
            <td> <?php echo $lastName;?>, <?php echo $firstName;?> </td>
           
            <td><?php echo $vl;?></td>
            <td><?php echo $sl;?></td>
            <td><?php echo $as_of;?></td>
            
         
            <td>
                <button class="ui icon mini green button"  onclick="addCredits('<?php echo $employees_id ?>')" style="margin-right: 5px;"><i class="icon plus"></i></button>
                <button class="ui icon mini blue button"  onclick="editCredits('<?= $employees_id ?>',
																						                                '<?= $row["as_of"] ?>',
                                                                             '<?= $row["vl"] ?>',
                                                                             '<?= $row["sl"] ?>')"
                                                                        
                                                               style="margin-right: 5px;"><i class="icon edit"></i></button>
            </td>  
        
         </tr>

    <?php
    }
    ?>
    </tbody>
    </table>
</center></div>
  
</div>

<script>
 $(document).ready(function() {
        $("#search_name").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#leaveCredits_table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
  });
 function load(){
    $("#leaveCredits_table").load("lm_leaveCredits.php",{
      load: true
    });
  }
function addCredits(employees_id){
    $("#addModal").modal({
      onApprove: function(){
        $.post('lm_leaveCredits_proc.php', {
            addCredits: true,
            employees_id: employees_id,
              as_of: $('#as_of').val(),
              vl: $("#vl").val(),
              sl: $("#sl").val(),
        }, function(data, textStatus, xhr) {
          $(load);
        });
      },
    }).modal('show');

  }

  function editCredits(employees_id,as_of,vl,sl){
    $("#employees_id").val(employees_id);
    $("#as_of").val(as_of);
    $("#vl").val(vl);
    $("#sl").val(sl);
    $("#addModal").modal({
      onApprove: function(){
        $.post('lm_leaveCredits_proc.php', {
            addCredits: true,
            employees_id: employees_id,
              as_of: $('#as_of').val(),
              vl: $("#vl").val(),
              sl: $("#sl").val(),
        }, function(data, textStatus, xhr) {
          $(load);
        });
      },
    }).modal('show');

  }
</script>
<?php
    require_once "footer.php";
?>