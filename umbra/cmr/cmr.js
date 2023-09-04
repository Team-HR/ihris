function modal(i,data1,data2) {
	$('#'+i.id+"Modal").modal('show');
	htmlId = i.id+"Modal";
	if(htmlId=='addcmrbtnModal'){
		addcmrbtnModalCont(data1);
	}
}
function cmrPeriod(){
	var i = document.forms['cmrform'];
	$.post('umbra/cmr/configs.php',{
		year  : i['year'].value,
		AddPeriod :""
	} , function(data, textStatus, xhr) {
		if (data!='1'){
			alert(data);
		}else{
			alert('Create!!');
			$('#addPeriodModal').modal('hide');
			loadPeriod();
		}
	});
}
function loadPeriod(){
		$('#cmrPeriod').html("<tr style='text-align: center'><td  colspan='7' ><img src='assets/images/loading.gif' style='transform:scale(0.1);margin-top:-100px'></td></tr>");
	$.post('umbra/cmr/configs.php', {
		viewPeriod: true
	} , function(data, textStatus, xhr) {
		$('#cmrPeriod').html(data);
	});
}
function cmpEmpView(cmrId) {
		$('#cmpEmpView').html("<td colspan='7' style='text-align: center'><img src='assets/images/loading.gif' style='transform:scale(0.1);margin-top:-100px'></td>");
		$.post('umbra/cmr/configs.php', {
			cmrId : cmrId,
			cmpEmpView: true 
		}, function(data, textStatus, xhr) {
			$('#cmpEmpView').html(data);
		});
}
function addcmrbtnModalCont(cmrEmpId){
	$('#addcmrbtnModal').html("<center>><img src='assets/images/loading.gif' style='transform:scale(0.1);margin-top:-100px'></center>");
	$.post('umbra/cmr/configs.php', {
		cmrEmpId :cmrEmpId,
		addcmrbtnModal: true
	} , function(data, textStatus, xhr) {
		$('#addcmrbtnModal').html(data);
	});
}
function cmrEmpData(cmrempId,i){
	cmrId = cmrempId;
	i=i;
	date = $("#crmData_date").val();
	content = $("#crmData_content").val();
	note = $("#crmData_note").val();
	if (date==''||content==""||note=="") {
		alert("Fill all Empty Field/s");
	}else{
		$.post('umbra/cmr/configs.php', {
			date:date,
			cmrempId:cmrempId,
			cmrEmpData:true,
			content:content,
			note:note
		} , function(data, textStatus, xhr) {
			addcmrbtnModalCont(cmrId);
			cmpEmpView(i);
		});
	}
}
function showModalForm(i){
	if(i.id=="btnformModal"){
		$("#"+i.id).hide();
		$("#addcmrdata").show();
	}else{
		$("#addcmrdata").hide();
		$("#btnformModal").show();
	}
}
function removecmr(i,cmrId){
	cmrId=cmrId;
	$.post('umbra/cmr/configs.php', {
		removeEmp : true,
		cmrEmp : i 
	}, function(data, textStatus, xhr) {
		if (data=="1") {
			cmpEmpView(cmrId);
		}else{
			alert(data);
		}
	});
}
function cmrempdataremove(dataId,i,cmr){
	$con = confirm("Are You Sure You Want to Remove This?");
	if($con==false){

	}else{
		$.post('umbra/cmr/configs.php', {
			cmrempdataremove: true,
			dataId: dataId
		}, function(data, textStatus, xhr) {
			if (data=='1') {
				addcmrbtnModalCont(i);
				cmpEmpView(cmr);
			}else{
				alert(data);
				addcmrbtnModalCont(i);
			}
		});
	}
}
function cmrempDataEditView(dataId,cmrempId){
	$('#addcmrbtnModal').html("<center>><img src='assets/images/loading.gif' style='transform:scale(0.1);margin-top:-100px'></center>");
	$.post('umbra/cmr/configs.php', {
		cmrempDataEditView : true,
		dataId : dataId,
		cmrempId : cmrempId
	}, function(data, textStatus, xhr) {
		$('#addcmrbtnModal').html(data);
	});
}

function saveEditedcmrData(dataId,cmrempId){

	date = $('#editcmr_date').val();
	content = $('#editcmr_content').val();
	note = $('#editcmr_note').val();
	// alert(note);
	$('#addcmrbtnModal').html("<center><img src='assets/images/loading.gif' style='transform:scale(0.1);margin-top:-100px'></center>");
	$.post('umbra/cmr/configs.php', {
		saveEditedcmrData:true,
		date:date,
		content:content,
		note:note,
		dataId:dataId
	}, function(data, textStatus, xhr) {
		if(data=='1'){
			addcmrbtnModalCont(cmrempId);
		}else{
			alert(data);
			cmrempDataEditView(dataId,cmrempId);
		}
	});
}