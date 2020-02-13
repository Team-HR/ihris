<!DOCTYPE html>
<html>
<head>
	<title></title>
  	<script src="jquery/jquery-3.3.1.min.js"></script>
</head>
<body>
<style type="text/css">
	input {
		width: 90%;
		/*background: transparent;*/
		border: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		
		b =0;
		$.each($('.drow'), function(index, val) {
			a = b+1;
			b = a+1;
			html = '<td width="4%" align="center">'+
        '<label><input type="checkbox" name="checkbox'+a+'" class="chb'+index+'" value="1" /> Yes</label>'+
        '</td>'+
        '<td width="4%" align="center">'+
        	'<label><input type="checkbox" name="checkbox'+b+'" class="chb'+index+'" value="0" /> No</label>'+
        '</td>';
		if (index != 0) {
			html += '<td width="4%" align="center">'+
        	'<input type="text" class="remarks'+index+'"/>'+
        	'</td>';
		}
		
		$(this).append(html);

			$(".chb"+index).change(function() {
			    $(".chb"+index).prop('checked', false);
			    $(this).prop('checked', true);
			    // console.log($(this).val());
			});

		});
			

	});



	function checked(){
		// alert()
		rows = [];
		$.each($('.drow'), function(index, val) {
			value0 = $('.chb'+index+':checked').val();
			value1 = "";
			if (index != 0) {
				value1 = $('.remarks'+index).val();	
			}
			
			arr = {'polarity':value0,'remarks':value1};
			// console.log(arr);
			rows.push(arr);
		});
		console.log(rows);
		
	}
</script>
<button onclick="checked()">Submit</button>
<table cellspacing="0" cellpadding="2" border="1" width="100%">
	<tr class="drow">
        <td width="10%"><b>Name</b></td>
        <td width="60%" colspan="4"></td>
        <td editable width="22%"><b>Same name in PDS</b></td>
<!--         <td width="4%" align="center">
        	<label><input type="checkbox" class="chb" value="1" /> Yes</label>
        </td>
        <td width="4%" align="center">
        	<label><input type="checkbox" class="chb" value="0" /> No</label>
        </td> -->
    </tr>
    <tr>
        <td width="15%" colspan="2"><b>Position Title</b></td>
        <td width="55%" colspan="3">$position_title</td>
        <td width="22%"><b>SG/Step</b></td>
        <td width="4%"></td>
        <td width="4%"></td>
    </tr>
    <tr>
        <td width="10%"><b>Agency</b></td>
        <td width="60%" colspan="4"></td>
        <td width="22%"><b>Compensation</b></td>
        <td width="4%"></td>
        <td width="4%"></td>
    </tr>
</table>

<table id="mainTable" cellspacing="0" cellpadding="2" border="1" width="100%">
    <tr>
        <td width="70%" colspan="5"><i><b>CRITERIA</b></i></td>
        <td width="4%" align="center"><b>YES</b></td>
        <td width="4%" align="center"><b>NO</b></td>
        <td width="22%" align="center"><b><i>REMARKS</i></b></td>
    </tr>
    <tr class="drow">
        <td width="15%" colspan="4"><b>QS: 1. Education</b></td>
        <td width="55%">$education</td>
<!--         <td width="4%" align="center">
        	<label><input type="checkbox" class="chb1" value="1" /> Yes</label>
        </td>
        <td width="4%" align="center">
        	<label><input type="checkbox" class="chb1" value="0" /> No</label>
        </td>
        <td width="22%">
        	<input type="text" style="width:100%; border: none;" name="remarks1">
        </td> -->
    </tr>
    <tr class="drow">
        <td width="15%" colspan="4"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Experience</b></td>
        <td width="55%">$experience</td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="15%" colspan="4"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Training</b></td>
        <td width="55%">$training</td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="15%" colspan="4"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Elig.</b></td>
        <td width="55%">$eligibility</td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4a. If  practice of profession -valid license;drivers-Cert allowed</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>5.&nbsp;&nbsp;&nbsp;&nbsp; -Other reqts: Residency (LGU Dept Heads)</b> <cite>Localization w/n 6 mos residency</cite></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>5a. Check if info in PUBLICATION is correct (plantilla item#, QS, etc)</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr>
        <td width="100%" colspan="8"><i><b>COMMON REQUIREMENTS</b></i></td>
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>6. CS Form in triplicate</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>7. Employment Status</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>8. Nature of Appointment</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>9. Signature of Appointing Authority (all original)</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>10. Date of Signing</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>11. Certification by HRMO: in order, Publ./Posting of Vacany</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>12. Certification by PSB Chair at back of apntmt (or Copy of PSB mins.)</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>13. Same Item No, and Position Title in POP?</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>14. PDS.</b> <small>(new form) completely filled out, w/ signature of swearing officer, date subscribed , no blank (write n/a)</small></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>14a. PDF-QS for position, not of appointee; Actual duties/fuunctions</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>15. If accredited, submitted within 30 days of succeeding month?</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>16. If regulated, submitted within 30 days from issuance?</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr>
        <td width="100%" colspan="8"><i><b>ADDITIONAL REQUIREMENTS</b></i></td>
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>17. If w/ erasures - initialed & w/ Cert of Erasures/Alterations by AA</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>18. If w/ decided admin/crim case-CTC of decision from deciding body</b></td>
        <!-- <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small>As declared in the appointee's PDS</small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>19. If with discrepancy in personal info: CSC Reso or Order</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>19a. If promotion & employee been found guilty of admin case & suspension or fine was imposed: Cert by appointing autho as to when decisions became final & when penalty was served</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>20. COMELEC ban: COMELEC exemption</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="10%" rowspan="4"><b>21. LGU:</b></td>
        <td width="60%" colspan="4"><b>Cert by AA-aptmt issued in accordance w/ limitns in RA 7160</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%" colspan="4"><b>Cert by Accountant-funds available</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%"  colspan="4"><b>Dept Head: Sanggunian Reso-concurrence of majority; or Cert by Sasnggunian Sec/HRMO confirm'g non-action by Sanggunian w/n 15 days from date of submission</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%"  colspan="4"><b>If creation/recals & w/ appropriation: Sang.ordinance-subj to review by SP if component cities/muni; by DBM if province</b></td>
 <!--        <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>22. Appointment involving change of status from temp to perm under cats.in MC 11s1996:CAT.I TESDA cert; CAT.II-Perf rating 2 periods;CAT.IV-license</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>23. Non-Disciplinary Demotion: Cert by AA that demotion is not a result of an admin case PLUS written consent of appointee</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>24. Oath of Office (Gov't ID, ID# & Date issued) & Assumption</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr>
        <td width="100%" colspan="8"><i><b>OTHER REQUIREMENTS</b></i></td>
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Temporary/Provisional aptmt: Cert by AA vouching absence of eligible</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Reclassification: NOSCA approved by DBM/Memo Order by GCG</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="10%" rowspan="3"><b>Nature</b></td>
        <td width="60%" colspan="4"><cite>If Orig. first-time perm from noncareer, reap frm temp to perm, reemp under perm, first time to closed career, provisional, cat.3:</cite> <b>"The appointee shall undergo probationary period..."</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%" colspan="4"><b>If Promotion, VS rating for 1 rating period in present position</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%" colspan="4"><b>If Promotion, not more than 3 SGs higher - JUSTIFICATION</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="60%" colspan="5"><b>If Transfer, copy of previous appointment</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%"></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Plantilla info: name of replaced employee, Plantilla Item# and Page</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Issued after election up to June 30 by outgoing elective AA</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Lost in the last election, except Brgy Election</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Citizenship (if dual, should renounce & not use foreign passport, unless acquired by birth)</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>Appointment received by the appointee - Name, Signature, Date</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
    <tr class="drow">
        <td width="70%" colspan="5"><b>S-card completely filled out back to back? Not multiple s-card?</b></td>
<!--         <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td> -->
    </tr>
</table>
<table cellpadding="2">
    <tr>
        <td width="70%" colspan="5"></td>
        <td width="4%"></td>
        <td width="4%"></td>
        <td width="22%" align="center"><small></small></td>
    </tr>
    <tr>
        <td width="10%" border="1"></td>
        <td width="60%"><b>Approved/Validated</b></td>
        <td width="4%" border="1"></td>
        <td width="26%" colspan="2"><b>Disapproved/Invalidated</b></td>
    </tr>
    <tr>
        <td width="70%"><cite>Created & used on dateOfUse</cite></td>
        <td width="30%" borderbottom="1" colspan="4"><b>Reasons:</b>_________________________________</td>
    </tr>
    <tr>
        <td width="70%" border="1"><b>Evaluated by:<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PHOEBE P. TUPAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Supervising HR Specialist</cite>
        </b></td>
        <td width="30%" border="1">
        <b>Approved/Signed by:<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ATTY. GINA A. CRUCIO &nbsp;&nbsp;&nbsp;&nbsp;Date:<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<cite>Director II</cite>
        </b></td>
    </tr>
</table>
<!-- table end -->
</body>
</html>