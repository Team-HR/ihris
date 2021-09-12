<?php
// $title = "Testing";
// require 'header.php';
?>

<script type="text/javascript" src="scripts/Lister.js"></script>
<script type="text/javascript">
	var training = new Lister("Training"),
		eligibility = new Lister("Eligibility"),
		awards = new Lister("Awards"),
		records = new Lister("Records"),
		experience = [],
		yosArr = {
			Temporary: "",
			JOW: "",
			Casual: "",
			Contractual: "",
			Permanent: "",
			Elective: "",
			Coterminus: ""
		},
		fields = {
			name: {
				identifier: 'name',
				rules: [{
					type: 'empty',
					prompt: 'Field empty! Please enter the name of Applicant'
				}]
			},
		};

	$(document).ready(function() {
		$("#training").html(training.render());
		$("#eligibility").html(eligibility.render());
		$("#awards").html(awards.render());
		$("#records").html(records.render());
		$(autoEnter);
		$(autoEnterExp);
		// $(autoEnterYos);
		$("#gender").dropdown();
		$("#civilStatus").dropdown();
		$(".inputListerYos").keypress(function(e) {
			if (e.which == 13) {
				$(".inputListerYosBtn").click();
			}
		});
	});

	function editApplicant(applicant_id) {
		header = '<i class="icon blue edit"></i> Edit Applicant';
		$("#addNewModalheader").html(header);
		$(resetForm);
		$.post('rsp_addApplicant_modal_proc.php', {
			getApplicantData: true,
			applicant_id: applicant_id
		}, function(data, textStatus, xhr) {
			
			arr = JSON.parse(data);
			console.log('arr:',arr);
			var dates = [];
			$.each(arr[10], function(i, val) {

				day1 = val[3] ? val[3].split("-") : "";
				day2 = val[4] ? val[4].split("-") : "";

				var date = [
					// val[3] ? day1[0] + '-' + day1[1] : "",
					// val[3] && day1[2] != '00' ? day1[2] : "",
					// val[4] ? day2[0] + '-' + day2[1] : "",
					// val[4] && day2[2] != '00' ? day2[2] : "",
					day1[0] ? day1[0] : "",
					day1[1] ? day1[1] : "",
					day1[2] ? day1[2] : "",
					day2[0] ? day2[0] : "",
					day2[1] ? day2[1] : "",
					day2[2] ? day2[2] : ""
				]
				arr[10][i] = arr[10][i].slice(0, -2)
				$.each(date, function(k, dat) {
					arr[10][i].push(dat);
				});
			});


			console.log('get_arr:',arr);
			$(setInputs(arr));

			$("#applicantForm").form({
				on: "submit",
				inline: true,
				keyboardShortcuts: false,
				onSuccess: function(e) {
					e.preventDefault();
					data = getInputs();
					console.log('sent_data: ', data);
					$.post('rsp_addApplicant_modal_proc.php', {
						editApplicant: true,
						data: data,
						applicant_id: applicant_id
					}, function(data, textStatus, xhr) {
						/*optional stuff to do after success */
						$(resetForm);
						$(load);
						$("#addNewModal").modal("hide");
					});
				},
				fields: fields
			});


			$("#addNewModal").modal({
				closable: false,
				onApprove: function() {
					return false;
				},
				onDeny: function() {
					$(resetForm);
				}
			}).modal("show");
		});
	}



	function setInputs(arr) {
		// console.log(arr);
		$(".dataInput").each(function(index, el) {

			if (index !== 2 && index !== 3 && index !== 8) {
				$(el).val(arr[index]);
			} else if (index === 8) {
				$(el).val(arr[14]);
			} else {
				$(el).dropdown("set selected", arr[index]);
			}
			// console.log($(el).val());
		});

		arr1 = [arr[8], arr[11], arr[12], arr[13]];

		$.each(objArray, function(index, val) {
			if (array = arr1[index]) {
				objArray[objArray[index]] = array;
			} else if (arr1[index] === null) {
				objArray[objArray[index]] = [];
			}
			createList(objArray[index]);
		});

		yosArr = arr[9];
		$(createYosField);
		experience = arr[10];
		$(createExperienceList);

	}

	function getInputs() {
		var data = [];
		$(".dataInput").each(function(index, el) {
			// console.log($(el));
			if (index !== 2 && index !== 3) {
				data.push($(el).val());
			} else {
				data.push($(el).dropdown("get value"));
			}
		});

		$.each(objArray, function(index, val) {
			data.push(objArray[objArray[index]]);
		});
		// data.push(objArray);
		data.push(yosArr);


		exp = [];

		$.each(experience, function(i, val) {

			date1 = "";
			if (val[3]) {
				date1 = val[3] + '-' + (val[4] ? val[4] : "00") + '-' + (val[5] ? val[5] : "00");
				// if (date1 == "-") {
				// 	date1 = "";
				// } else if (date1 == "-00-00") {
				// 	date1 = "";
				// }
			}

			date2 = "";
			if (val[6]) {
				date2 = val[6] + '-' + (val[7] ? val[7] : "00") + '-' + (val[8] ? val[8] : "00");
				// if (date2 == "-") {
				// 	date2 = "";
				// } else if (date2 == "-00-00") {
				// 	date2 = "";
				// }

			}

			exp[i] = experience[i].slice(0, -6);
			exp[i].push(date1);
			exp[i].push(date2);
		});

		console.log('exp_after_slice:', exp);



		// console.log('exp:',experience);




		data.push(exp);


		// console.log(data);
		return data;
	}

	function addExperience() {
		// console.log($("#experienceAdd input"));
		var insideExp = [],
			isEmpty = false;

		$("#experienceAdd input").each(function(index, el) {
			insideExp.push($(el).val());
			if (index === 0 && $(el).val() === "") {
				isEmpty = true;
			}
		});
		console.log('insideExperience:', insideExp);
		// console.log('dateMonth1:', $('#dateMonth1').val());
		// console.log(isEmpty);
		if (!isEmpty) {
			experience.push(insideExp);
			createExperienceList();
			$("#experienceAdd input").each(function(index, el) {
				$(el).val("");
			});
			console.log('experience after add:', experience);
		}

	}

	function createExperienceList() {
			console.log('experience: ',experience);
		if (experience) {
			var view = "";
			$("#experienceList").html("");
			$.each(experience, function(index, val) {
				/* iterate through array or object */
				view += '<div class="item experienceItem" style="padding: 0px !important;">';
				view += '<div class="fields" id="testfield" style="margin-bottom: 2px !important;">';
				view += '<div class="three wide field">';
				view += '<input onkeyup="onChangeSave(' + index + ',0,$(this).val())" type="text" value="' + val[0] + '">';
				view += '</div>';
				view += '<div class="three wide field">';
				view += '<input onkeyup="onChangeSave(' + index + ',1,$(this).val())" type="text" value="' + val[1] + '">';
				view += '</div>';
				view += '<div class="three wide field">';
				view += '<input onkeyup="onChangeSave(' + index + ',2,$(this).val())" type="text" value="' + val[2] + '">';
				view += '</div>';
				view += '<div class="three wide field">';



				// onkeyup="onChangeSave(' + index + ',2,$(this).val())"
				view += '<label>From:</label>';
				view += '<div class="ui labeled mini input" style="margin-bottom: 5px;">';
				view += '	<div class="ui label">Year:</div>';
				view += '	<input type="number" value="' + val[3] + '" onchange="onChangeSave(' + index + ',3,$(this).val())" placeholder="Year" min="1950">';
				view += '</div>';
				view += '<div class="ui labeled mini input" style="margin-bottom: 5px;">';
				view += '	<div class="ui label">Month:</div>';
				view += '	<input type="number" value="' + val[4] + '" onchange="onChangeSave(' + index + ',4,$(this).val())" placeholder="1-12 (or Leave Blank)" min="1" max="12">';
				view += '</div>';
				view += '<div class="ui labeled mini input">';
				view += '	<div class="ui label">Day:</div>';
				view += '	<input type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)" value="' + val[5] + '" onchange="onChangeSave(' + index + ',5,$(this).val())">';
				view += '</div>';
				view += '</div>';
				view += '<div class="three wide field">';
				view += '<label>To:</label>';
				view += '	<div class="ui labeled mini input" style="margin-bottom: 5px;">';
				view += '	<div class="ui label">Year:</div>';
				view += '<input type="number" value="' + val[6] + '" onchange="onChangeSave(' + index + ',6,$(this).val())" placeholder="Year" min="1950">';
				view += '</div>';
				view += '<div class="ui labeled mini input" style="margin-bottom: 5px;">';
				view += '	<div class="ui label">Month:</div>';
				view += '	<input type="number" value="' + val[7] + '" onchange="onChangeSave(' + index + ',7,$(this).val())" placeholder="1-12 (or Leave Blank)" min="1" max="12">';
				view += '</div>';
				view += '<div class="ui labeled mini input">';
				view += '	<div class="ui label">Day:</div>';
				view += '	<input type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)" value="' + val[8] + '" onchange="onChangeSave(' + index + ',8,$(this).val())">';
				view += '</div>';

				view += '</div>	';



				// <div class="three wide field">
				// 	<label>From:</label>
				// 	<div class="ui labeled mini input" style="margin-bottom: 5px;">
				// 		<div class="ui label">
				// 			Year:
				// 		</div>
				// 		<input type="number" placeholder="Year" min="1950">
				// 	</div>
				// 	<div class="ui labeled mini input" style="margin-bottom: 5px;">
				// 		<div class="ui label">
				// 			Month:
				// 		</div>
				// 		<input type="number" placeholder="1-12 (or Leave Blank)" min="1" max="12">
				// 	</div>
				// 	<div class="ui labeled mini input">
				// 		<div class="ui label">
				// 			Day:
				// 		</div>
				// 		<input type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)">
				// 	</div>
				// </div>
				// <div class="three wide field">
				// 	<label>To:</label>
				// 	<div class="ui labeled mini input" style="margin-bottom: 5px;">
				// 		<div class="ui label">
				// 			Year:
				// 		</div>
				// 		<input type="number" placeholder="Year" min="1950">
				// 	</div>
				// 	<div class="ui labeled mini input" style="margin-bottom: 5px;">
				// 		<div class="ui label">
				// 			Month:
				// 		</div>
				// 		<input type="number" placeholder="1-12 (or Leave Blank)" min="1" max="12">
				// 	</div>
				// 	<div class="ui labeled mini input">
				// 		<div class="ui label">
				// 			Day:
				// 		</div>
				// 		<input id="day2" type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)">
				// 	</div>
				// </div>



				view += '<div class="one wide field">';
				view += '<button type="button" onclick="removeExperience(' + index + ')" class="ui small icon basic button"><i class="icon trash"></i></button>';
				view += '</div>';
				view += '</div>';
				view += '</div>';

			});

			$("#experienceList").append(view);
		} else {
			$("#experienceList").html('<i style="padding: 15px; text-align: center; color: lightgrey;">n/a</i>');
		}
	}

	function removeExperience(index) {
		experience.splice(index, 1);
		createExperienceList();
	}

	function onChangeSave(index0, index1, val) {
		// console.log("Here in: "+index0+" wherein index: "+index1+" change to value: "+val);
		experience[index0][index1] = val;
		console.log(experience);
	}


	function resetForm() {
		$("#applicantForm").form("reset");
		$.each($("#applicantForm input"), function(index, val) {
			/* iterate through array or object */
			$(this).val("");
			// console.log('rest',$(this));
		});
		$("textarea").val("");
		$(".ui.dropdown").dropdown("restore defaults");
		experience = [];
		yosArr = {
			Temporary: "",
			JOW: "",
			Casual: "",
			Contractual: "",
			Permanent: "",
			Elective: "",
			Coterminus: ""
		};
		training.resetLister();
		eligibility.resetLister();
		awards.resetLister();
		records.resetLister();
		$(createYosField);
		$(createExperienceList);

	}

	function autoEnterExp() {
		$(".inputListerExp").keypress(function(e) {
			if (e.which == 13) {
				$(".inputListerExpBtn").click();
			}
		});
	}

	function autoEnterYos() {
		$(".inputListerYos").keypress(function(e) {
			if (e.which == 13) {
				$(".inputListerYosBtn").click();
			}
		});
	}



	function addNewApplicant() {
		// $(resetForm);
		// $("input [name='name']").val("result.tittle");
		$('#addApplicantSearch').search('hide results');
		name = $("#searchInput").val();
		// $("input [name='name']").val(name);
		// console.log(name);
		console.log($(setInputs([name, null, "", "", "", "", "", "", [], {
				Temporary: "",
				JOW: "",
				Casual: "",
				Contractual: "",
				Permanent: "",
				Elective: ""
			},
			[],
			[],
			[],
			[], ""
		])));
		// $(addNewApplicant());
		$("#applicantForm").form({
			on: "submit",
			inline: true,
			keyboardShortcuts: false,
			onSuccess: function(e) {
				e.preventDefault();
				data = getInputs();
				console.log('Submitted', data);
				$.post('rsp_addApplicant_modal_proc.php', {
					addNew: true,
					data: data,
					type: "comparative",
					rspvac_id: <?= $rspvac_id ?>
				}, function(data, textStatus, xhr) {
					/*optional stuff to do after success */
					$(resetForm);
					$(load);
					$("#addNewModal").modal("hide");
				});
			},
			fields: fields
		});

		header = '<i class="icon blue circle user"></i> Add New Applicant';
		$("#addNewModalheader").html(header);
		$("#addNewModal").modal({
			closable: false,
			onApprove: function() {
				return false;
			},
			onDeny: function() {
				$(resetForm);
			}
		}).modal("show");

	}




	function addApplicant() {
		$('#addApplicantSearch').search('set value', '');
		$.post("rsp_addApplicant_modal_proc.php", {
			getApplicants: true
		}, function(data) {
			content = $.parseJSON(data);
			// $("#inputName .menu").html(data);
			header = '<i class="icon blue circle user"></i> Add Applicant';
			$("#addApplicantHeader").html(header);
			$("#addApplicant").modal({
				closable: false,
			}).modal('show');

			$('#addApplicantSearch').search({
				source: content,
				cache: false,
				error: {
					noResults: 'Click <div class="ui mini basic green button" onclick="addNewApplicant()"><i class="icon add"></i>Add</div> to add records for this new applicant.'
				},
				onSelect: function(result, response) {
					console.log(result.title);
					console.log(result.id);

					$.post("rsp_addApplicant_modal_proc.php", {
						addExistingApplicant: true,
						applicant_id: result.id,
						rspvac_id: <?= $rspvac_id ?>
					}, function(data) {
						$(load);
					})


					$("#addApplicant").modal('hide');
					$('#addApplicantSearch').search('set value', '');
					$('#addApplicantSearch').search('hide results');
				},
				onResults: function(response) {
					console.log(response.results.length);
					if (response.results.length === 0) {
						$("#addNewApplicantBtn").show();
					} else if (response.results.length > 0) {
						$("#addNewApplicantBtn").hide();
					}
				}
			});

		});





	}
</script>

<div class="ui tiny modal" id="addApplicant">
	<div class="ui blue header" id="addApplicantHeader"></div>
	<div class="content">
		<div class="ui search" id="addApplicantSearch">
			<div class="ui fluid icon input">
				<input id="searchInput" class="prompt" type="text" placeholder="Add applicant...">
				<i class="search icon"></i>
			</div>
			<div class="results"></div>
		</div>
	</div>
	<div class="actions">
		<div id="addNewApplicantBtn" class="ui mini basic green button" onclick="addNewApplicant()" style="display: none;"><i class="icon add"></i>Add</div>
		<div class="ui mini basic button deny"><i class="icon cancel"></i>Cancel</div>
	</div>
</div>




<div class="ui large modal" id="addNewModal" style="background-color: lightgrey !important;">
	<div class="ui blue header" id="addNewModalheader"></div>
	<div class="scrolling content">
		<form class="ui small form" id="applicantForm" method="POST">
			<!-- personal information start -->
			<h3 class="ui dividing blue header">Personal Information</h3>
			<div class="fields">
				<div class="eleven wide field">
					<label>Name:</label>
					<input class="dataInput" type="text" name="name" placeholder="Enter fullname of applicant...">
				</div>
				<div class="two wide field">
					<label>Age:</label>
					<input class="dataInput" type="text" name="age" placeholder="Enter age...">
				</div>
				<div class="three wide field">
					<label>Gender:</label>
					<!-- <input type="text" name="gender" placeholder="Enter gender..."> -->
					<select class="dataInput" class="ui compact dropdown" id="gender">
						<option value="">Gender</option>
						<option value="Female">Female</option>
						<option value="Male">Male</option>
					</select>
				</div>
			</div>
			<div class="fields">
				<div class="three wide field">
					<label>Civil Status:</label>
					<!-- <input type="text" name="" placeholder="Civil status..."> -->
					<select class="dataInput" class="ui compact dropdown" id="civilStatus">
						<option value="">Civil Status</option>
						<option value="Single">Single</option>
						<option value="Married">Married</option>
						<option value="Annulled">Annulled</option>
						<option value="Widowed">Widowed</option>
					</select>
				</div>
				<div class="three wide field">
					<label>Mobile No:</label>
					<input class="dataInput" type="text" name="mobileNum" placeholder="Mobile number...">
				</div>
				<div class="ten wide field">
					<label>Address:</label>
					<input class="dataInput" type="text" name="address" placeholder="Enter full address...">
				</div>
			</div>
			<!-- personal information end -->

			<!-- education start -->
			<h3 class="ui dividing blue header">Education</h3>
			<div class="fields">
				<div class="eight wide field">
					<label>Education:</label>
					<input class="dataInput" type="text" name="education" placeholder="Enter the highest degree earned...">
				</div>
				<div class="eight wide field">
					<label>School:</label>
					<input class="dataInput" type="text" name="school" placeholder="Enter last school attended...">
				</div>
			</div>
			<!-- education end -->
			<!-- qualification start -->
			<h3 class="ui dividing blue header">Trainings</h3>
			<div class="field" id="training"></div>
			<h3 class="ui dividing blue header">Experience</h3>


			<script type="text/javascript">
				$(document).ready(function() {
					// $("#yearsOfService").dropdown();
					$(createYosDropdown);
					// $(addApplicant);
				});

				function createYosDropdown() {

					options = '<option selected="" value="">Select status</option>';
					counter = 0;
					$.each(yosArr, function(index, val) {
						if (!val) {
							options += '<option value="' + index + '">' + index + '</option>';
						}
					});
					$("#yearsOfService").html(options);
					$("#yearsOfService").dropdown();
					$("#yearsOfService").dropdown("restore defaults");
				}

				function addYearsOfService() {
					selected = $("#yearsOfService").dropdown("get value");
					if (selected) {
						yosArr[selected] = $("#inputAdder").val();
						$("#inputAdder").val("");
					}
					selected = $("#yearsOfService").dropdown("get value");
					$(createYosField);
				}

				function removeField(index) {
					yosArr[index] = "";
					$(createYosField);
				}

				function yosOnChangeSave(index, val) {
					yosArr[index] = val;
					if (!val) {
						$(createYosField);
					}
				}

				function createYosField() {
					$(createYosDropdown);
					html = "";
					$.each(yosArr, function(index, val) {
						if (val) {
							html += '<div class="three wide field" id="jowField" style="display: inline-block;">';
							html += '<label>' + index + ': <i class="icon right link times" onclick="removeField(\'' + index + '\')"></i></label>';
							html += '<input name="' + index + '" type="text" placeholder="No of.." value="' + val + '" onkeyup="yosOnChangeSave(\'' + index + '\',$(this).val());">';
							html += '</div>';
						}
					});
					$("#yosContainer").html(html);
				}
			</script>


			<div class="fields">
				<div class="six wide field">
					<label>Years of Gov't Service:</label>
					<div class="ui action input inputListerYos">
						<input id="inputAdder" type="text" placeholder="No. of Years">
						<select class="ui selection compact dropdown" id="yearsOfService"></select>
						<div onclick="addYearsOfService()" class="ui white basic icon button inputListerYosBtn"><i class="icon add"></i></div>
					</div>
				</div>
				<div style="width: 100%;" id="yosContainer"></div>
			</div>

















			<div class="fields" id="experienceAdd">
				<div class="three wide field">
					<label>Position:</label>
					<input class="inputListerExp" type="text" name="positionAdd" placeholder="Enter Position...">
				</div>
				<div class="three wide field">
					<label>Status:</label>
					<input class="inputListerExp" type="text" name="statusAdd" placeholder="Enter Status...">
				</div>
				<div class="three wide field">
					<label>Company:</label>
					<input class="inputListerExp" type="text" name="companyAdd" placeholder="Enter Company...">
				</div>
				<div class="three wide field">
					<label>From:</label>
					<div class="ui labeled mini input" style="margin-bottom: 5px;">
						<div class="ui label">
							Year:
						</div>
						<input type="number" placeholder="Year" min="1950">
					</div>
					<div class="ui labeled mini input" style="margin-bottom: 5px;">
						<div class="ui label">
							Month:
						</div>
						<input type="number" placeholder="1-12 (or Leave Blank)" min="1" max="12">
					</div>
					<div class="ui labeled mini input">
						<div class="ui label">
							Day:
						</div>
						<input type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)">
					</div>
				</div>
				<div class="three wide field">
					<label>To:</label>
					<div class="ui labeled mini input" style="margin-bottom: 5px;">
						<div class="ui label">
							Year:
						</div>
						<input type="number" placeholder="Year" min="1950">
					</div>
					<div class="ui labeled mini input" style="margin-bottom: 5px;">
						<div class="ui label">
							Month:
						</div>
						<input type="number" placeholder="1-12 (or Leave Blank)" min="1" max="12">
					</div>
					<div class="ui labeled mini input">
						<div class="ui label">
							Day:
						</div>
						<input id="day2" type="number" min="1" max="31" placeholder="1-31 (or Leave Blank)">
					</div>
				</div>
				<div class="one wide field">
					<label><i class="icon arrow down"></i></label>
					<button type="button" class="ui icon small basic button inputListerExpBtn" onclick="addExperience()"><i class="icon add"></i></button>

				</div>
			</div>



















			<div class="ui list" id="experienceList" style="border: 1px solid lightgrey; border-radius: 3px; padding: 5px; padding-bottom: 0px;">
			</div>
			<h3 class="ui dividing blue header">Eligibility</h3>
			<div class="field" id="eligibility"></div>
			<h3 class="ui dividing blue header">Awards, Citations Received</h3>
			<div class="field" id="awards"></div>
			<h3 class="ui dividing blue header">Records of Infractions</h3>
			<div class="field" id="records"></div>
			<h3 class="ui dividing blue header">Remarks</h3>
			<div class="field">
				<label>Remarks:</label>
				<textarea class="dataInput" id="remarksArea" placeholder="Remarks?"></textarea>
			</div>


			<div class="ui error message"></div>
		</form>
	</div>
	<div class="actions">
		<button type="button" onclick="$('#'+this.form.id).form('submit');" form="applicantForm" class="ui tiny basic blue button approve"><i class="icon save"></i> Save</button>
		<button class="ui tiny basic button deny"><i class="icon cancel"></i> Cancel</button>
	</div>
</div>
<!-- ui form end -->



<?php
// require 'footer.php';
?>