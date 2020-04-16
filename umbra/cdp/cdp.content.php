<?php 
	$sql = "SELECT * from positiontitles";
	$sql = $mysqli->query($sql);
	$Category = "";
	$cat_array = [];
	while($positions = $sql->fetch_assoc()){
		if ($positions['category']) {
			array_push($cat_array, $positions['category']);
		}
	}
	$cat_array = array_unique($cat_array);
	foreach ($cat_array as $cat) {
		$Category .="<option value='$cat'>$cat</option>";		
	}

	$department = "";
	$depSql = "SELECT * from `department`";
	$depSql = $mysqli->query($depSql);
	while($dep = $depSql->fetch_assoc()){
		$department .= "<option value='$dep[department_id]'>$dep[department]</option>";
	}
?>
<div class="ui segment">
	<form class="noprint ui form" id='cdpSearchForm' style="border:1px solid #00000045;padding: 10px; border-radius: 5px 5px">
		<h3>General Search</h3>
	  <div class="six fields">
	    <div class="field">
	     	<label>Departments</label>
			<select class="ui dropdown" name="department">
			  <option value="">All</option>
			  <?=$department?>
			</select>
	    </div>
	    <div class="field">
	     	<label>Gender</label>
			<select class="ui dropdown" name="gender">
			  <option value="">Both</option>
			  <option value="MALE">Male</option>
			  <option value="FEMALE">Female</option>
			</select>
	    </div>
	    <div class="field">
	     	<label>Employment Status</label>
			<select class="ui dropdown" name="empStatus">
			  <option value="">Both</option>
			  <option value="CASUAL">CASUAL</option>
			  <option value="PERMANENT">PERMANENT</option>
			</select>
	    </div>
	    <div class="field">
	      <label>Category</label>
	      	<select class="ui dropdown" name="category">
			  <option value=""></option>
			  <?=$Category?>
			</select>
	    </div>
	    <div class="field">
	      <label>Period</label>
			<select class="ui dropdown" name="period">
			  <option value=""></option>
			  <option value="January - June">January - June</option>
			  <option value="July - December">July - December</option>
			</select>
		</div>
	    <div class="field">
	      <label>Year</label>
			<input class="ui meduim" name="year" type="number">
		</div>
	  </div>
	  <button class="ui submit button" name='submitBtn'>Search</button>
	</form>
	<br>
	<br>
	  <div class="noprint ui form" id="cdpFormSearchRecommendationCont" style="display:none;border:1px solid #00000045;padding: 10px; border-radius: 5px 5px">
	    <h3>Comments and Recommendtion Search</h3>
	        <div class="field">
	          <label>Comments and Recommendation</label>
	          <textarea rows="2" name="cdp_searchComment" id='cdpFormSearchRecommendation'></textarea>
	      	</div>
	  </div>
	<br>
	<br>
	<div id="cdpTable"></div>
</div>

<script type="text/javascript">
	(function(){
		"use strict";
		function _(el){
			return document.getElementById(el);
		}
		// form submition
		_("cdpSearchForm").addEventListener('submit',searchData);
		function searchData(){
			event.preventDefault();
			var ev = event.target.elements;
			var valid = "";
			if(ev.category.value==""){
				valid += "2"; 
				  ev.category.parentElement.classList.add("error");
			}else{
				valid += ""; 
				ev.category.parentElement.classList.remove("error");
			}
			if(ev.period.value==""){
				valid += "3"; 
				ev.period.parentElement.classList.add("error");
			}else{
				valid += ""; 
				ev.period.parentElement.classList.remove("error");
			}
			if(ev.year.value.length != 4){
				valid += "4"; 
				  ev.year.parentElement.classList.add("error");
			}else{
				valid += ""; 
				ev.year.parentElement.classList.remove("error");
			}
			if(valid==""){
				ev.submitBtn.disabled = 'true';
				_("cdpTable").innerHTML = "<center><img src='umbra/img/searching.gif' width='20%'></center>";
				$.post('umbra/cdp/serchResult.php',{
					'cdp_department': ev.department.value,
					'cdp_gender': ev.gender.value,
					'cdp_empStatus': ev.empStatus.value,
					'cdp_category': ev.category.value,
					'cdp_period': ev.period.value,
					'cdp_year':ev.year.value,
				},function(data, textStatus, xhr){
					_("cdpFormSearchRecommendationCont").style.display = "";			
					_("cdpTable").innerHTML = data;
					ev.submitBtn.disabled = '';
				});
			}
		}
		_("cdpFormSearchRecommendation").addEventListener('keyup',findFromTable);
		function findFromTable(){
			event.preventDefault();
			var filter = event.target.value;
			var tr = _('cdpResultTable').children[1].children;
			var i;
			  for (i = 0; i < tr.length; i++) {
			    var td = tr[i].getElementsByTagName("td")[6];
			    if (td) {
			      var txtValue = td.textContent || td.innerText;
			      if (txtValue.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
			        tr[i].style.display = "";
			      } else {
			        tr[i].style.display = "none";
			      }
			    }       
			  }
		}
	})();


</script>