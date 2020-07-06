<?php 
  $title = "Plantilla Report"; 
  require_once "header.php";
?>
<script type="text/javascript">

  var dept_filters = "";

  $(document).ready(function() {

    $("#dept").dropdown();
    $("#status").dropdown();
    $("#gender").dropdown();
  
  });
  

</script>

<div class="ui container" style="background: white">
 
  
  <center> <p style="font-size: 20px; padding: 20px;"><b>REPORT ON PLANTILLA</b></p>

          <p><b>Generate report by:</b></p>

          <div class="ui form" style="padding:20px; width:900px" >

             <div class="inline fields">
                <div class="field">
                  <div class="ui radio checkbox">
                    <input type="radio" name="regular">
                    <label>Regular</label>
                  </div>
                </div>
                <div class="field">
                  <div class="ui radio checkbox">
                    <input type="radio" name="regular_new">
                    <label>Regular NEW Format</label>
                  </div>
                </div>
                <div class="field">
                  <div class="ui radio checkbox">
                    <input type="radio" name="casual">
                    <label>Casual</label>
                  </div>
                </div>

               <div class="four wide field">
                      <select id="gender">
                       <option value="">Gender</option>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                      </select>
                </div>
                  <br>
                <div class="four wide field">
                      <select id="status">
                       <option value="">Status</option>
                            <option value="elective">Elective</option>
                            <option value="permanent">Permanent</option>
                            <option value="co-term">Co-term</option>
                            <option value="temporary">Temporary</option>
                      </select>
                </div>         
              </div>
        <br>
               <div class="three wide field">
                   <label>As of Date:</label>
                    <input  id="date" type="date">
               </div>
          
              <div class="eight wide field">
                <label>Department:</label>
                  <select id="dept">
                    <option value="">Select Department</option>
                        <?php
                          $result = $mysqli->query("SELECT * FROM `department`");
                            while ($row = $result->fetch_assoc()) {
                                $department_id = $row["department_id"];
                                $department = $row["department"];
                                    print "<option value=\"{$department_id}\">{$department}</option>";
                                }
                        ?>
                    </select>
              </div>
        
      <br><br>
         <div class="actions">

            <div class="ui green button mini">
              Generate
            </div>

            <div class="ui deny button mini">
              Cancel
            </div>
          
        </div>
    </div>

<?php 
	require_once "footer.php";
?>
