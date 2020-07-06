<?php
$id = $_GET["id"];
require_once "_connect.db.php";

$sql = "SELECT * FROM `plantillas_test` LEFT JOIN `positiontitles` ON `plantillas_test`.`position_title` = `positiontitles`.`position_id`  
									LEFT JOIN `department` ON `plantillas_test`.`department_id` = `department`.`department_id`
									LEFT JOIN `employees` ON `plantillas_test`.`incumbent` = `employees`.`employees_id`  
										WHERE `id` = '$id' ";

$result = $mysqli->query($sql);
$row = $result->fetch_assoc();


$sql2 = "SELECT * FROM `plantillas_test` LEFT JOIN `qualification_standards` ON `plantillas_test`.`position_title` = `qualification_standards`.`position_id`  
                 
                  ";

$sql2 = $mysqli->query($sql2);
$sql2 = $sql2->fetch_assoc();

$sql2['education']= $sql2["education"];
if (!$sql2['education']) {
      $sql2['education']=  "<i style='color:grey'>N/A</i>";
    }

$sql2['training']= $sql2["training"];
if (!$sql2['training']) {
      $sql2['training']=  "<i style='color:grey'>N/A</i>";
    }

$sql2['experience']= $sql2["experience"];
if (!$sql2['experience']) {
      $sql2['experience']=  "<i style='color:grey'>N/A</i>";
    }

$sql2['eligibility']= $sql2["eligibility"];
if (!$sql2['eligibility']) {
      $sql2['eligibility']=  "<i style='color:grey'>N/A</i>";
    }

$sql2['competency']= $sql2["competency"];
if (!$sql2['competency']) {
      $sql2['competency']=  "<i style='color:grey'>N/A</i>";
    }

$training= $sql2["training"];

$position_title= $row["position"];
$item_no = $row["item_no"];
$functional_title = $row["functional"];
if (!$functional_title) {
			$functional_title = "<i style='color:grey'>N/A</i>";
		}
$category = $row["category"];
$level = $row["level"];
$department = $row["department"];
$page_no = $row["page_no"];
$original_appointment = $row["original_appointment"];
$last_promo = $row["last_promotion"];
$step = $row["step"];
$vacated_by = $row["vacated_by"];

$reason_of_vacancy = $row["reason_of_vacancy"];
		if (!$reason_of_vacancy) {
			$reason_of_vacancy = "<i style='color:grey'>N/A</i>";
		}
$supervisor = $row["supervisor"];
$abolish = $row["abolish"];

$title = $item_no."  ".$position_title;

$firstName	=	$row["firstName"];
		$lastName	=	$row["lastName"];
		
		if ($row["middleName"] == "") {
			$middleName = "";
		} else {
			$middleName	= $row["middleName"];
			$middleName = $middleName[0].".";
		}

		$extName	=	strtoupper($row["extName"]);
		$exts = array('JR','SR');

		if (in_array(substr($extName,0,2), $exts)) {
			$extName = " ";

		} else {
			$extName = " ".$extName;
		}
		
		if (!$lastName) {
			$lastName = "<i style='color:grey'>N/A</i>";
		}
		
		$fullname = (" $firstName $middleName $lastName ").$extName;//$lastName.", ".$firstName." ".$middleName." ".$extName;
					



require_once "header.php";
?>


<script type="text/javascript">

$(document).ready(function() {
        $("#tabs .item").tab();
        $("#dept_search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#dept_table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
        $(load);
        $("#clearBtn").click(function(event) {
          $("#newDept").val("");
        });
  });
  
  function load(){
    $("#tableContent").load("departmentsetup_proc.php",{
      load: true
    });
  }

  function deleteRow(id){
    $("#deleteModal").modal({
      onApprove: function(){
        $.post('plantilla_proc.php', {
          deleteData: true,
          id: id,
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          $(load);
        });
      }
    }).modal("show");
  }


 function editRow(id,incumbent,department,position,step,item_no,page_no,original_appointment,last_promo,vacator,reason,other,supervisor,abolish){

 	$("#editIncumbent").val(incumbent);
    $("#editDept").val(department);
    $("#editPos").val(position);
	$("#editStep").val(step);
    $("#editItem").val(item_no);
    $("#editPage").val(page_no);
    $("#editOriginal").val(original_appointment);
    $("#editLastPromo").val(last_promo);
    $("#editVacator").val(vacator);
    $("#editReason").val(reason);
    $("#editOther").val(other);
    $("#editSupervisor").val(supervisor);
    $("#editAbolish").val(abolish);



    $("#editModal").modal({
      onApprove: function(){
        $.post('plantilla_proc.php', {
          editData: true,
          id: id,
          incumbent: $("#editIncumbent").val(),
          department: $("#editDept").val(),
          position: $("#editPos").val(),
          step: $("#editStep").val(),
          item_no: $("#editItem").val(),
          page_no: $("#editPage").val(),
          original_appointment: $("#editOriginal").val(),
          last_promo: $("#editLastPromo").val(),
          vacator: $("#editVacator").val(),
          reason: $("#editReason").val(),
          other: $("#editOther").val(),
          supervisor: $("#editSupervisor").val(),


        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          $(load);
        });
      }
    }).modal("show");
  }

   function addStatementWorkModal(){
    $.post("plantilla_detail.php",{
      addWorkStatement:true,
      percentile: $("#addPercentile").val(),
      no: $("#addNo").val(),
      work_statement: $("#addWorkStatement").val(),
    },function(data,status){
      $(load);
      $(clear);
    });
  }

     function addWorkStatementFunc(){
    $("#addWorkStatementModal").modal({
        onApprove : function() {
          $(addWorkStatement);
        // save msg animation start 
          $("#saveMsg").transition({
            animation: 'fly down',
            onComplete: function () {
              setTimeout(function(){ $("#saveMsg").transition('fly down'); }, 1000);
            }
          });
        // save msg animation end
      }
    }).modal("show");
  
  }
</script>

<div id="deleteModal" class="ui mini modal">
  <i class="close icon"></i>
  <div class="header">
    Deleting Data
  </div>
  <div class="content">
    <p>Are you sure you want to delete this data?</p>
  </div>
  <div class="actions">
    <div class="ui deny button mini">
      No
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Yes
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>



<!----edit--->
<div id="editModal" class="ui small modal">
  <div class="header">
  Edit Plantilla Detail
  </div>
<div class="content">
  <div class="ui form">

    <div class="two fields">
        <div class="eight wide field">
          <label>Employee:</label>
              <!-- <input id="inputPos" type="text" placeholder="Position"> -->
                  <select id="editIncumbent">
                     <option value="">Employee Name</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                          print "<option value=\"{$employees_id}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </select>
     </div>
        
        <div class="eight wide field">
          <label>Department:</label>
              <select id="editDept">
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
  </div>

  <div class="four fields">
     <div class="eight wide field">
        <label>Position:</label>
          <select id="editPos">
        <!-- <input id="inputPos" type="text" placeholder="Position"> -->
          <option value="">Position</option>
               <?php $result = $mysqli->query("SELECT * FROM `positiontitles` ORDER BY `position` ASC");
              while ($row= $result->fetch_assoc()){
                    $position_id = $row["position_id"];
                    $position = $row["position"];
                    $salary_schedule = $row["salary_schedule"];
                    if ($row["functional"] == "") {
                      $functional = $row["functional"];
                    } else {
                      $functional = " - ".$row["functional"];
                    }
                   print "<option value= \"{$position_id}\">$position $functional (C $salary_schedule)</option>";
                  }
                ?>
            </select>
     </div>

      <div class="three wide field">
         <label>Step No.</label>
          <input  id="editStep" type="number" placeholder="No" autocomplete="off" required="">
      </div>

       <div class="three wide field">
            <label>Item No:</label>
              <input  id="editItem" type="text" placeholder="Item No" autocomplete="off" required="">
        </div>
        
        <div class="three wide field">
            <label>Page No:</label>
              <input id="editPage"  type="number" placeholder="Page" autocomplete="off" required="">
        </div>
    
  </div>

    <div class="three fields">
      <div class="eight wide field">
      <label>Original Appointment</label>
        <input  id="editOriginal" type="date" placeholder="Select Department" autocomplete="off" required="">
      </div>
      <div class="eight wide field">
      <label>Last Promotion:</label>
        <input  id="editastPromo" type="date" placeholder="Select Department" autocomplete="off" required="">
      </div>

  </div>
  
  <div class="four fields">
    <div class="seven wide field">
      <label>Vacated By:</label>
       
                  <select id="editVacator">
                      <option value="">Vacated by</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                    while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];
                          
                        
                            print "<option value=\"{$firstName} {$middleName} {$lastName} {$extName}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                        }
                ?>
            </select>
    </div>

  
      <div class="four wide field">
        <label>Reason of Vacancy:</label>
            <select id="editReason">
                <option value="">---</option>
                <option value="transfer">Transfer</option>
                <option value="promotion">Promotion</option>
                <option value="retirement">Retirement</option>
                <option value="others">Others</option>    
            </select>
        </div>

      <div class="five wide field">
          <label> - </label>
            <input  id="editOther" type="text" placeholder="Other reason" >
      </div>
  </div>
 
  <div class="two fields">
        <div class="eight wide field">
          <label>Supervisor:</label>
             <select id="editSupervisor">
                     <option value="">Supervisor</option>
                     <?php $result = $mysqli->query("SELECT * FROM `employees`");
                       while ($row= $result->fetch_assoc()){
                          $employees_id = $row["employees_id"];
                          $firstName = $row["firstName"];
                          $middleName = $row["middleName"];
                          $lastName = $row["lastName"];
                          $extName = $row["extName"];

                            print "<option value=\"{$firstName} {$middleName} {$lastName} {$extName}\"> {$firstName} {$middleName} {$lastName} {$extName}</option>";
                          }
                ?>
            </select>
        </div>

        <div class="eight wide field">
          <label>Abolish ?:</label>
            <select class="ui fluid dropdown" id="editAbolish">
              <option value="">---</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
          </select>     
        </div>
  </div>

  </div>
</div>
  <div class="actions">
    <div class="ui deny button mini">
      No
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Update
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>


<!----end---->

<div class="ui container">
  
<div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>

  	<div class="item">
			<h3 style="color: white;"><?php echo $position_title ?></h3>
		</div>
  	<!--- <h3><i class=" icon"></i> Department Setup</h3>---->
  <div class="right item">
    <div class="ui right input">
     
    
    </div>
  </div>
</div>

<div class="ui top attached tabular menu" id="tabs">
  <a class="item active" data-tab="departments">Plantilla Details</a>
  <a class="item" data-tab="state">Statement of Duties</a>
  <a class="item" data-tab="qs">Qualification Standards</a>
</div>
<div class="ui bottom attached segment tab active" data-tab="departments">
 	
			<table class="ui  table">
			  	<tr style="float:right;"><button class="ui icon mini red button" style="margin-bottom: 10px; float:right" onclick="deleteRow('<?php echo $id; ?>')" >
			  								<i class="white icon trash"  title="Delete"></i> Delete</button>
			  						
			  							<button class="ui icon mini green button" 

			  							 onclick="editRow('<?php echo $id; ?>')"   

			  							 style="margin-bottom: 10px; float:right" >
			  								<i class="white icon edit" title="Edit"></i> Edit</button>

			   </tr>

			  <tbody>
			    <tr>
			      <td><b>Department</b></td>
			      <td><?php  echo $department?></td>
			    </tr>
			    <tr>
			      <td><b>Position Title</b></td>
			      <td><?php  echo $position_title?></td>
			    </tr>
			    <tr>
			      <td><b>Page No.</b></td>
			      <td><?php  echo $page_no?></td>
			    </tr>
			    <tr>
			      <td><b>Functional Title</b></td>
			      <td><?php  echo $functional_title?></td>
			    </tr>
			    <tr>
			      <td><b>Level/Category</b></td>
			      <td><?php  echo $category[0]?>  / <?php  echo $level?></td>
			    </tr> 
			    <tr>
			      <td><b>Incumbent Employee</b></td>
			      <td><?php  echo $fullname?></td>
			    </tr>
			    <tr>
			      <td><b>Orginal Appointment</b></td>
			      <td><?php  echo $original_appointment?></td>
			    </tr>
			    <tr>
			      <td><b>Last Date of Promotion</b></td>
			      <td><?php  echo $last_promo?></td>
			    </tr>
			    <tr>
			      <td><b>Step No</b></td>
			      <td><?php  echo $step?></td>
			    </tr>
			    <tr>
			      <td><b>Vacated by</b></td>
			      <td><?php  echo $vacated_by?></td>
			    </tr>
			    <tr>
			      <td><b>Reason of Vacancy</b></td>
			      <td><?php  echo $reason_of_vacancy?></td>
			    </tr>
			    <tr>
			      <td><b>Supervisor</b></td>
			      <td><?php  echo $supervisor?></td>
			    </tr>
			    <tr>
			      <td><b>Abolish</b></td>
			      <td><?php  echo $abolish[0]?></td>
			    </tr>
			  </tbody>
			</table>
			   
		  </tbody>
		</table>	
</div>
<div class="ui bottom attached segment tab" data-tab="state">
  <div id="sectionsContainer"></div>

<!----add work state--->
<div id="addWorkStatementModal" class="ui mini modal">
  <div class="header">
  </div>

      <div class="three wide field">
         <label>Percentile (%):</label>
          <input  id="addPercentile" type="number" placeholder="Percentile" autocomplete="off" required="">
      </div>

       <div class="three wide field">
            <label>No.:</label>
              <input  id="addNo" type="number" placeholder="No" autocomplete="off" required="">
        </div>
        
        <div class="three wide field">
            <label>Work Statement:</label>
              <input id="addWorkStatement"  type="text" placeholder="Work Statement" autocomplete="off" required="">
        </div>

  <div class="actions">
    <div class="ui deny button mini">
      No
    </div>
    <div class="ui blue right labeled icon approve button mini">
      Add
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>


<!----end---->

    <table class="ui table">

        <tbody>
        <tr>
  
                      <button class="ui icon mini green button" 

                       onclick="addStatementWorkFunc('<?php echo $id; ?>')"   

                       style="margin-bottom: 10px; float:right" >
                        <i class="white icon edit" title="Add"></i> Add</button>

         </tr>
      
            <td>

              <button class="ui icon mini red button" style="margin-bottom: 10px; float:right" onclick="deleteRow('<?php echo $id; ?>')" >
                        <i class="white icon trash"  title="Delete"></i></button>

              <button class="ui icon mini green button" style="margin-bottom: 10px; float:right" onclick="deleteRow('<?php echo $id; ?>')" >
                        <i class="white icon edit"  title="Edit"></i></button>

               
            </td>
            <td><?php  echo $department?></td>
            <td><?php  echo $department?></td>
            <td><?php  echo $department?></td>
          </tr>
  
        </tbody>
      </table>
         
      </tbody>
    </table>  
</div>

<div class="ui bottom attached segment tab" data-tab="qs">
 <table class="ui table">
			 
			  <tbody>

			    <tr>
			      <td><b>Education</b></td>
			      <td><?php echo $sql2['education'];?></td>
			    </tr>
			    <tr>
			      <td><b>Training</b></td>
			      <td><?php echo $sql2['training'];?></td>
			    </tr>
			    <tr>
			      <td><b>Experience</b></td>
			      <td><?php echo $sql2['experience'];?></td>
			    </tr>
			    <tr>
			      <td><b>Eligibility</b></td>
			      <td><?php echo $sql2['eligibility'];?></td>
			    </tr>
			    <tr>
			      <td><b>Competency</b></td>
			      <td><?php echo $sql2['competency'];?></td>
			    </tr> 
			  </tbody>
			</table>
			   
		  </tbody>
		</table>	
</div>

</div>
</div>
<?php 
	require_once "footer.php";
?>
