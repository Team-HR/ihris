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
				<th rowspan ="2">Date-Submited</th>
				<th rowspan ="2">Date-Recieved</th>
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
					$dif = date_diff($d1,$d2);
					$view .= "
						<tr>
							<td>$emp[lastName]</td>
							<td>$emp[firstName]</td>
							<td>$emp[middleName]</td>
							<td>$emp[extName]</td>
							<td>$row[date_submitted]</td>
							<td>$row[date_appraised]</td>
							<td>".$dif->format('%a')."</td>
						</tr>
					";
				}
				echo $view;

			 ?>
		</tbody>
	</table>


</div>