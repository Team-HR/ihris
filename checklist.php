<?php

$title = "Comparative Data";
require "_connect.db.php";
require "header.php";

$rspcomp_id = $_GET['rspcomp_id'];
$sql = "SELECT *, `rsp_vacant_positions`.`education` AS `education_cri`, `rsp_vacant_positions`.`experience` AS `experience_cri`,`rsp_vacant_positions`.`training` AS `training_cri`, `rsp_vacant_positions`.`eligibility` AS `eligibility_cri` FROM `rsp_comparative` JOIN  `rsp_vacant_positions` ON `rsp_comparative`.`rspvac_id` = `rsp_vacant_positions`.`rspvac_id` JOIN `rsp_applicants` ON `rsp_comparative`.`applicant_id` = `rsp_applicants`.`applicant_id` WHERE `rsp_comparative`.`rspcomp_id`=$rspcomp_id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

$name = $row['name'];
$sg = $row['sg'];
$positiontitle = $row['positiontitle'];
$education_cri = $row['education_cri'];
$experience_cri = $row['experience_cri'];
$training_cri = $row['training_cri'];
$eligibility_cri = $row['eligibility_cri'];

// check if rscomp_id has already a checklist
$printReady = 'false';
$sql = "SELECT * FROM `rsp_comp_checklist` WHERE `rspcomp_id` = $rspcomp_id";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$data = array();
$date_signed = null;
if ($result->num_rows > 0) {
  $data = unserialize($row['data']);
  $date_signed = $row['date_signed'];
  $printReady = 'true';
}

// echo $date_signed;

?>

<div class="ui container" style="padding-left: 20px; padding-right: 20px;">
  <div class="printOnly" style="padding-top: 5px !important;"></div>
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button noprint" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="clipboard icon"></i> Appointment Processing Checklist <i class="caret right icon"></i> <?= 'name'; ?></h3>
    </div>

    <div class="right item noprint">
    </div>
  </div>
  <style type="text/css">
    input {
      width: 100%;
      border: 1px solid lightgrey;
      padding: 3px;
    }

    tr,
    td {
      padding: 0px none !important;
    }

    /*tr:has(input:hover){
  background-color: green;
}*/
    tr:hover {
      background-color: #376ba9;
      color: white;
    }

    th {
      background-color: #4075a94a;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {
      // $("#date_signed_input").val();
      // var dateSigned = <?= $date_signed ?>;
      // console.log(dateSigned);
      $(document).on('keydown', function(e) {
        if (e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
          e.cancelBubble = true;
          e.preventDefault();
          e.stopImmediatePropagation();

          // alert("Please use the Print PDF button below for a better rendering on the document");
          $(saveData(false));
        }
      });


      $(function() {
        var printReady = <?= $printReady ?>;
        if (printReady) {
          $('.printBTN').removeClass('disabled');
        }
      });


      b = 0;
      data = fetchData();
      $.each($('.drow'), function(index, val) {
        a = b + 1;
        b = a + 1;

        if (typeof data[index] == 'undefined') {
          polarity = null;
          remarks_val = "";
        } else {
          polarity = data[index].polarity;
          remarks_val = data[index].remarks;
        }

        html = '<td width="4%" align="center">' +
          '<label><input style="transform: scale(2)" type="checkbox" name="checkbox' + a + '" class="list-item-checkbox1 chb' + index + '" value="1" ' + checker(1, polarity) + '/></label>' +
          '</td>' +
          '<td width="4%" align="center">' +
          '<label><input style="transform: scale(2)" type="checkbox" name="checkbox' + b + '" class="list-item-checkbox2 chb' + index + '" value="0" ' + checker(0, polarity) + '/></label>' +
          '</td>';
        if (index != 0) {
          html += '<td width="22%" align="center">' +
            '<input style="width:100%" type="text" class="remarks' + index + '" value="' + remarks_val + '"/>' +
            '</td>';
        }

        $(this).append(html);


        $(".chb" + index).change(function() {
          $(".chb" + index).prop('checked', false);
          $(this).prop('checked', true);
        });



      });

      $('.remarksCompensation').val(data[45].remarks);

    });

    function fetchData() {

      data = <?= json_encode($data) ?>;
      // console.log(data);
      return data;
    }

    function checker(pole, polarity) {
      if (pole == polarity) {
        return 'checked';
      }
      return '';
    }

    function saveData(reload) {
      rows = [];
      $.each($('.drow'), function(index, val) {
        value0 = $('.chb' + index + ':checked').val();
        value1 = "";
        if (index != 0) {
          value1 = $('.remarks' + index).val().replace('"', '&quot;');
        }
        arr = {
          'polarity': value0,
          'remarks': value1
        };
        rows.push(arr);
      });

      val = $('.remarksCompensation').val();
      arr = {
        'polarity': "undefined",
        'remarks': val
      };
      rows.push(arr);

      // console.log(rows);
      var date_signed = $("#date_signed_input").val();
      // console.log(date_signed);
      $.post('checklist_proc.php', {
        saveData: true,
        data: rows,
        date_signed: date_signed,
        rspcomp_id: <?= $rspcomp_id ?>
      }, function(data, textStatus, xhr) {
        // console.log('rows: ', rows);
        // console.log(JSON.parse(data));
        arr = $.parseJSON(data);
        if (reload) {
          location.reload();
        } else {
          window.open('checklist_print.php?rspcomp_id=<?= $rspcomp_id ?>', '_blank');
        }
      });



    }
  </script>

  <button class="ui button green" onclick="saveData(true)"><i class="icon save"></i> Save</button>
  <a id="printBTN" class="printBTN ui button green disabled" target="_blank" onclick="saveData(false)"><i class="icon print"></i> Save & Print</a>
  <table class="ui table very compact" width="100%">
    <thead>
      <tr>
        <th colspan="8"></th>
      </tr>
    </thead>
    <tbody>
      <tr class="drow">
        <td width="10%">Name</td>
        <td width="60%" colspan="4"><?= strtoupper($name) ?></td>
        <td editable width="22%">Same name in PDS</td>
      </tr>
    </tbody>
  </table>

  <table class="ui table very compact" id="mainTable" width="100%" style="padding: 10px;">
    <tbody>
      <tr>
        <td width="15%" colspan="2">Position Title</td>
        <td width="55%" colspan="3  "><?= strtoupper($positiontitle) ?></td>
        <td width="2%">SG/Step</td>
        <td width="22%" colspan="2"><?= $sg ?></td>
      </tr>
      <tr>
        <td width="10%">Agency</td>
        <td width="60%" colspan="4"> LGU BAYAWAN CITY</td>
        <td width="8%">Compensation</td>
        <td width="22%" colspan="2">
          <input style="width:100%" type="text" class="remarksCompensation" value="">
        </td>
      </tr>
      <tr>
        <th width="70%" colspan="5"><i>CRITERIA</i></th>
        <th width="" align="center">YES</th>
        <th width="" align="center">NO</th>
        <th width="" align="center"><i>REMARKS</i></th>
      </tr>
      <tr class="drow">
        <td width="15%" colspan="4">QS: 1. Education</td>
        <td width="55%"><?= lister(unserialize($education_cri)) ?></td>
      </tr>
      <tr class="drow">
        <td width="15%" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. Experience</td>
        <td width="55%"><?= lister(unserialize($experience_cri)) ?></td>
      </tr>
      <tr class="drow">
        <td width="15%" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Training</td>
        <td width="55%"><?= lister(unserialize($training_cri)) ?></td>
      </tr>
      <tr class="drow">
        <td width="15%" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4. Elig.</td>
        <td width="55%"><?= lister(unserialize($eligibility_cri)) ?></td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4a. If practice of profession -valid license;drivers-Cert allowed</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">5.&nbsp;&nbsp;&nbsp;&nbsp; -Other reqts: Residency (LGU Dept Heads)</td>
      </tr>
      <!-- new row added as of Jan 2024  start-->
      <tr class="drow">
        <td width="70%" colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -Other reqts: Localization w/n 6 mos from retirements</td>
      </tr>
      <!-- new row added as of Jan 2024  end-->
      <tr class="drow">
        <td width="70%" colspan="5">5a. Check if info in PUBLICATION is correct (plantilla item#, QS, etc)</td>
      </tr>
      <tr>
        <th width="100%" colspan="8"><i>COMMON REQUIREMENTS</i></th>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">6. CS Form in triplicate</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">7. Employment Status</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">8. Nature of Appointment</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">9. Signature of Appointing Authority (all original)</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">10. Date of Signing</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">11. Certification by HRMO: in order, Publ./Posting of Vacany</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">12. Certification by PSB Chair at back of apntmt (or Copy of PSB mins.)</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">13. Same Item No, and Position Title in POP?</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">14. PDS. <small>(new form) completely filled out, w/ signature of swearing officer, date subscribed , no blank (write n/a)</small></td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">14a. PDF-QS for position, not of appointee; Actual duties/fuunctions</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">15. If accredited, submitted within 30 days of succeeding month?</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">16. If regulated, submitted within 30 days from issuance?</td>
      </tr>
      <tr>
        <th width="100%" colspan="8"><i>ADDITIONAL REQUIREMENTS</i></th>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">17. If w/ erasures - initialed & w/ Cert of Erasures/Alterations by AA</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">18. If w/ decided admin/crim case-CTC of decision from deciding body</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">19. If with discrepancy in personal info: CSC Reso or Order</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">19a. If promotion & employee been found guilty of admin case & suspension or fine was imposed: Cert by appointing autho as to when decisions became final & when penalty was served</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">20. COMELEC ban: COMELEC exemption</td>
      </tr>
      <tr class="drow">
        <td width="10%" rowspan="4">21. LGU:</td>
        <td width="60%" colspan="4">Cert by AA-aptmt issued in accordance w/ limitns in RA 7160</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="4">Cert by Accountant-funds available</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="4">Dept Head: Sanggunian Reso-concurrence of majority; or Cert by Sasnggunian Sec/HRMO confirm'g non-action by Sanggunian w/n 15 days from date of submission</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="4">If creation/recals & w/ appropriation: Sang.ordinance-subj to review by SP if component cities/muni; by DBM if province</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">22. Appointment involving change of status from temp to perm under cats.in MC 11s1996:CAT.I TESDA cert; CAT.II-Perf rating 2 periods;CAT.IV-license</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">23. Non-Disciplinary Demotion: Cert by AA that demotion is not a result of an admin case PLUS written consent of appointee</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">24. Oath of Office (Gov't ID, ID# & Date issued) & Assumption</td>
      </tr>
      <tr>
        <th width="100%" colspan="8"><i>OTHER REQUIREMENTS</i></th>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Temporary/Provisional aptmt: Cert by AA vouching absence of eligible</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Reclassification: NOSCA approved by DBM/Memo Order by GCG</td>
      </tr>
      <tr class="drow">
        <td width="10%" rowspan="3">Nature</td>
        <td width="60%" colspan="4"><cite>If Orig. first-time perm from noncareer, reap frm temp to perm, reemp under perm, first time to closed career, provisional, cat.3:</cite> "The appointee shall undergo probationary period..."</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="4">If Promotion, VS rating for 1 rating period in present position</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="4">If Promotion, not more than 3 SGs higher - JUSTIFICATION</td>
      </tr>
      <tr class="drow">
        <td width="60%" colspan="5">If Transfer, copy of previous appointment</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Plantilla info: name of replaced employee, Plantilla Item# and Page</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Issued after election up to June 30 by outgoing elective AA</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Lost in the last election, except Brgy Election</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Citizenship (if dual, should renounce & not use foreign passport, unless acquired by birth)</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">Appointment received by the appointee - Name, Signature, Date</td>
      </tr>
      <tr class="drow">
        <td width="70%" colspan="5">S-card completely filled out back to back? Not multiple s-card?</td>
      </tr>
      <tr>
        <th width="100%" colspan="8"><i>DATE PREPARED:</i></th>
      </tr>
      <tr>
        <td width="100%" colspan="8">
          <label for="">Input Date:</label>
          <div class="ui input">
            <input type="date" id="date_signed_input" value="<?= $date_signed ?>">
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- table end -->
  <button class="ui button green" onclick="saveData(true)"><i class="icon save"></i> Save</button>
  <a id="printBTN" class="printBTN ui button green disabled" target="_blank" onclick="saveData(false)"><i class="icon print"></i> Save & Print</a>

</div>
<?php
function lister($arr)
{
  $item = "*None Required";
  if (isset($arr) && !empty($arr)) {
    $item = "";
    foreach ($arr as $key => $value) {
      $item .= " *" . $value;
    }
  }

  return $item;
}
require_once "footer.php";

?>