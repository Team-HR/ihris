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
	 <table class="ui fixed table">
	 	<thead>
	 		<tr>
	 			<th></th>
	 			<th style="text-align:center">Period</th>
	 			<th style="text-align:center">Year</th>
	 			<th style="text-align:center">TYPE</th>
	 		</tr>
	 	</thead>
	 	<tbody>
	 		<?php 
	 			$sql = "SELECT * FROM prr ORDER BY 	prr_id DESC";
	 			$sql = $mysqli->query($sql);
	 			$view = "";
	 			while ($row=$sql->fetch_assoc()) {
	 				$view .="
	 					<tr>
	 						<td><a href='?rec=$row[prr_id]'><button class='ui icon button'><i class='folder outline icon'> </i></button></td>
	 						<td>$row[period]</td>
	 						<td>$row[year]</td>
	 						<td>$row[type]</td>
	 					</tr>
	 				";
	 			}
	 			echo $view;
	 		?>
	 	</tbody>
	 </table>
</div>