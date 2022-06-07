 <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon line chart"></i>Turn Around Time<span></span></h3>
   </div>
   <div class="right item">
    <div class="ui right input">
    </div>  
  </div>
</div>
<div>
	<table class="ui celled table">
		<thead style="text-align: center">
			<tr>
				<th colspan ="4">Name</th>
				<th rowspan ="2">Date-Submited <br>(mm/dd/yyyy)</th>
				<th rowspan ="2">Date-Appraised <br>(mm/dd/yyyy)</th>
				<th rowspan ="2">Total</th>
			</tr>
			<tr>
				<th>Last Name</th>
				<th>Given Name</th>
				<th>Middle Name</th>
				<th>Ext Name</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$sql = "SELECT * from prrlist where prr_id='$_GET[rec]'";
				$sql = $mysqli->query($sql);
				$view = "";
				while ($row =$sql->fetch_assoc()) {
					$emp  = "SELECT * from employees where employees_id ='$row[employees_id]'";
					$emp = $mysqli->query($emp);
					$emp = $emp->fetch_assoc();
					$d1 = date_create($row['date_submitted']);
					$d2 =date_create($row['date_appraised']);
					$check = explode('-', $row['date_appraised']);
					$total = "0";

					if($check[0]!='0000'){
						$total = date_diff($d1,$d2);
						$total = $total->format('%a');
					}
					
					$date_submitted = "-";
					if ($row['date_submitted'] != "0000-00-00") {
						$date_submitted = date('m/d/Y',strtotime($row['date_submitted']));
					}					
					$date_appraised = "-";
					if ($row['date_appraised'] != "0000-00-00") {
						$date_appraised = date('m/d/Y',strtotime($row['date_appraised']));
					}

					$view .= "
						<tr>
							<td>$emp[lastName]</td>
							<td>$emp[firstName]</td>
							<td>$emp[middleName]</td>
							<td>$emp[extName]</td>
							<td>$date_submitted</td>
							<td>$date_appraised</td>
							<td>".$total." days</td>
						</tr>
					";
				}
				echo $view;

			 ?>
		</tbody>
	</table>


</div>