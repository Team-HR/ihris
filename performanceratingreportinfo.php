<?php $title = "Performance Rating Report";
require_once "header.php";
require_once "_connect.db.php";
$prr_id = $_GET["prr_id"];
$type = $_GET["type"];
$title = title($mysqli);

?>
<div id="vue_prr">
  <template>
    <div class="ui container">
      <div class="ui borderless blue inverted mini menu noprint">
        <div class="left item" style="margin-right: 0px !important;">
          <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
          </button>
        </div>
        <div class="item">
          <h3><i class="icon line chart"></i> PERFORMANCE RATING REPORT <span>(<?= $title['period'] ?> <?= $title['year'] ?>)</span></h3>
        </div>
        <div class="right item">
          <div class="ui right input">
            <button class="ui icon blue mini button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button>
            <!--       <div class="ui icon fluid input" style="width: 300px;">
        <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
        <i class="search icon"></i>
      </div> -->
          </div>
        </div>
      </div>
    </div>
    <div class="ui fluid container" style="padding: 20px;">
      <!-- <button class="ui button"> Populate List</button> -->
      <div class="ui top attached tabular menu noprint">
        <a class="item active" data-tab="first">Overall</a>
        <a class="item" data-tab="second">Department</a>
      </div>
      <div class="ui bottom attached tab segment active" style="border: none" data-tab="first">
        <div class="noprint" style="float: right;padding: 10px;background: black;border-radius:10px">
          <h5 style="color: white"><b>Legend</b></h5>
          <div style="color:cyan"><b>cyan</b> - not submited</div>
          <div style="color:yellow"><b>yellow</b> - reviewed</div>
          <div style="color:white"><b>white</b> - validated</div>
        </div>

        <!--
       <div class="ui icon fluid input noprint" style="width: 300px;margin:auto;z-index: 10px">
        <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
        <i class="search icon"></i>
      </div><br>
 -->
        <div style="text-align: center">
          <div style="width: 100%">
            <center>
              <div style="float:left;width:37%;">
                <img src="assets/images/bayawanLogo.png" width="90px" style="margin-left:50%;margin-top: 10px">
              </div>
              <div style="float: left;width:25%;">
                <h5>
                  Republic of the Philippines<br>Province of Negros Oriental<br>CITY OF BAYAWAN
                </h5>
              </div>
              <div style="float: left;width:37%">

              </div>
              <div style="clear:both"></div>
            </center>
          </div>
          <div style="width:100%">
            <h3>
              <?= $title['period'] ?> <?= $title['year'] ?><br>
              PERFORMANCE RATING REPORT<br>
              <?= $_GET['type'] ?>
            </h3>
          </div>
          <br>
        </div>
        <p>Agency Name: <b> LGU-BAYAWAN CITY</b></p>
        <p>Address: <b> Bayawan City, Negros Oriental</b></p>
        <!-- <p>Legend</p> -->
        <div id="tableDiv">

          <div class="ui noprint" style="background:white;padding: 10px">
            <div class="ui icon fluid input noprint" style="width: 300px;margin:auto;z-index: 10px">
              <input id="_search" type="text" placeholder="Search..." onkeyup="find(this)">
              <i class="search icon"></i>
            </div>
            <br>
            <h1 style="text-align: center">Add Employee</h1>
            <div class="ui fluid action input">
              <div class="ui fluid search selection employee_to_add dropdown">
                <input type="hidden" id="empidprr">
                <i class="dropdown icon"></i>
                <div class="default text">Select Employee To add</div>
                <div class="menu">
                  <div v-for="emp in emps" :key="emp.id" class='item' :data-value="emp.employees_id">{{emp.text}}</div>
                </div>
              </div>
              <button class="ui button" @click="addempprr(prr_id)">ADD</button>
            </div>
          </div>
          <div class="ui noprint" style="background:white;padding: 10px">
            <label for="">Sort by:</label>
            <select v-model="sort_by" class="ui compact selection sort_by dropdown">
              <option selected value="lastName">Last Name</option>
              <option value="date_submitted">Date Submitted</option>
            </select>
            <div class="ui basic button" @click="is_asc = !is_asc">
              <i v-if="is_asc" class="ui icon angle double up"></i>
              <i v-else class="ui icon angle double down"></i>
              {{is_asc?'Asc':'Desc'}}
            </div>
            <!-- </div> -->
          </div>
          <table class="ui mini very compact celled structured table">
            <thead class="center-align">
              <tr>
                <th class="noprint" rowspan="2"></th>
                <th rowspan="2">CSID</th>
                <th colspan="4">Employees Name</th>
                <th rowspan="2">Gender</th>
                <th rowspan="2">Date Submitted (mm-dd-yyyy)</th>
                <th rowspan="2">Appraisal Type</th>
                <th rowspan="2">Date Appraised (mm/dd/yyyy)</th>
                <th colspan="2">Rating</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2" colspan="2" class="noprint">Option</th>
              </tr>
              <tr>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Name Ext.</th>
                <th>Numerical</th>
                <th>Adjectival</th>
                <th class="noprint"></th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr style="text-align: center" v-if="is_loading">
                <td colspan="15"><img style="transform: scale(0.1); margin-top: -200px;" src="assets/images/loading.gif"></td>
              </tr>
              <!-- <tr v-for="item in items" :key="item.id">
                <td colspan="18">{{item}}</td>
              </tr> -->
              <tr v-for="item in items" :key="item.id" class="center-align" :style="'background:'+stage_color(item.stages)">
                <td class="noprint" nowrap>
                  <!-- <a :href="'employeeinfo.php?employees_id='+item.employees_id+'&spms'"><i class="icon link blue folder"></i></a> -->
                  <a :href="`performanceratingreportinfo.view_accomplishment_report.php?period_id=${item.period_id}&employees_id=${item.employees_id}`" target="_blank"><i class="icon link blue file"></i> View Accomplishment Report</a>
                  <!-- {{item.period_id}} {{item.employees_id}} -->
                </td>
                <!-- <td colspan="12">{{ item }}</td> -->
                <td>{{item.csid}}</td>
                <td class="left-align">{{item.lastName}}</td>
                <td class="left-align">{{item.firstName}}</td>
                <td>{{item.middleName}}</td>
                <td>{{item.extName}}</td>
                <td>{{item.gender}}</td>
                <td>{{item.date_submitted_view}}</td>
                <td>{{item.appraisal_type}}</td>
                <td>{{item.date_appraised_view}}</td>
                <td>{{item.numerical}}</td>
                <td>{{item.adjectival}}</td>
                <td>{{item.remarks}}</td>
                <td class="noprint">
                  <i class="ui icon link green edit" @click="ratingModal(item.prrlist_id,item. employees_id,item.prr_id)"></i>
                </td>
                <td class="noprint">
                  <i class="ui icon link blue square" @click="stateColor(item.prrlist_id, item.employees_id, item.prr_id, 'C')"></i>
                </td>
                <td class="noprint">
                  <i class="ui icon link yellow square" @click="stateColor(item.prrlist_id, item.employees_id, item.prr_id, 'Y')"></i>
                </td>
                <td class="noprint">
                  <i class="ui icon link square outline" @click="stateColor(item.prrlist_id, item.employees_id, item.prr_id, 'W')"></i>
                </td>
                <td class="noprint">
                  <i class="ui icon link red times" @click="removePerInfo(item.prrlist_id)"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <br>
        <br>
        <!-- Modal Add Rating-->
        <div class="ui modal" id="rating_modal"></div>

        <div id="cons">
          <p>Certified Correct:</p>
          <div style="text-align: center;width: 49%; float:left;">
            <p style="text-decoration: underline;line-height: 1px;font-weight:bolder;"> VERONICA GRACE P. MIRAFLOR </p>
            <p style="font-size: 10px;line-height: 1px"> CGDH-1 </p>
            <p style="font-size: 10px"> (Signature over Printed Name) </p><br>
            <p style="line-height: 1px;font-size: 10px;">Date: ________________ </p>
            <p style="font-size: 10px;line-height: 1px;padding-left:25px">(mm/dd/yyyy) </p>
          </div>
          <div style="width: 49%; float:left;padding:0px 50px 0px 50px">
            <div style="font-size: 10px;border: 2px solid black;padding:10px">
              <p><span style="font-weight: bold">FOR CSC ACTION:</span> Please don't write anything beyond this point</p>
              <p style="font-weight: bolder;line-height:1px ">DOCUMENT TRACKING </p>
              <p style="text-align: center">Received by:________________ Date:_________ <br>Encoded by:________________ Date:_________ <br> Posted by:_________________ Date:_________</p>
            </div>
          </div>
          <div style="clear:both"></div>
          <div>
            <br>
            <table style="border-collapse: collapse;margin: auto;">
              <thead>
                <tr>
                  <th class="noborder noright" style="width: 200px"></th>
                  <th class="noborder" style="width: 50px"></th>
                  <th style="width: 100px; border: 1px solid black;">Female</th>
                  <th style="width: 100px; border: 1px solid black;">Male</th>
                  <th style="width: 100px; border: 1px solid black;">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr style="text-align: center" v-if="!ova_rates.length">
                  <td colspan="5"><img style="transform: scale(0.1); margin-top: -200px;" src="assets/images/loading.gif"></td>
                </tr>
                <tr v-for="ova, o in ova_rates" :key="o">
                  <template v-if="o < 6">
                    <td class="noborder noright">{{ova.row}}</td>
                    <td class="noborder">=</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.female}}</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.male}}</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.total}} <i>({{ova.percent}}%)</i></td>
                  </template>
                </tr>
              </tbody>
            </table>

            <br><br>

            <table style="border-collapse: collapse;margin: auto;">
              <thead>
                <tr>
                  <th class="noborder noright" style="width: 200px"></th>
                  <th class="noborder" style="width: 50px"></th>
                  <th style="width: 100px; border: 1px solid black;">Female</th>
                  <th style="width: 100px; border: 1px solid black;">Male</th>
                  <th style="width: 100px; border: 1px solid black;">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr style="text-align: center" v-if="!ova_rates.length">
                  <td colspan="5"><img style="transform: scale(0.1); margin-top: -200px;" src="assets/images/loading.gif"></td>
                </tr>
                <tr v-for="ova, o in ova_rates" :key="o">
                  <template v-if="o == 6">
                    <td class="noborder noright">*{{ova.row}}</td>
                    <td class="noborder">=</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.female}}</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.male}}</td>
                    <td style="text-align: center; border: 1px solid black;">{{ova.total}}</td>
                  </template>
                </tr>
              </tbody>
            </table>

          </div>
          <!-- chart -->

          <br>
          <br>
          <br>
          <div style="width:800px;margin:auto;">
            <canvas id="myChart" width="200" height="200"></canvas>
          </div>


        </div>
      </div>
      <!-- end of data-first -->
      <div class="ui bottom attached tab segment" style="border: none" data-tab="second">

        <form name="departmentsForm" class="noprint" onsubmit="return load2(this)">
          <div class="ui form" style="margin-left: 26%">
            <label>Select Department</label>
            <div class="ui fields">
              <div class="eight wide field">
                <select class="ui dropdown" id="depView" name="departments">
                  <option></option>
                  <?php
                  $sql = "SELECT * FROM `department`";
                  $result = $mysqli->query($sql);
                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='$row[department_id]'>$row[department]</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="three wide field">
                <input class="ui primary button" type="submit" value="GO">
              </div>
            </div>
          </div>
        </form>

        <div id="DepartmentBody">

        </div>
      </div>
  </template>
</div>
<?php require_once "footer.php";
function title($mysqli)
{
  $sql = "SELECT * from prr where prr_id = '$_GET[prr_id]'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  return $row;
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    // $(load);
    $(Depshow)
    $('.menu .item').tab();
    // $('.ui.sticky').sticky({
    //   context: "#tableDiv"
    // });
    $(".sort_by.dropdown").dropdown({
      // fullTextSearch: true,
      // forceSelection: false,
    });
    $(".employee_to_add.dropdown").dropdown({
      fullTextSearch: true,
      forceSelection: false,
      clearable: true
    });
  });

  function _(el) {
    return document.getElementById(el)
  }

  function Depshow() {
    if (_("depView").value == "") {
      _("DepartmentBody").style.visibility = "hidden";
    } else {
      _("_table").style.visibility = "visible";
    }
  }
  // function load(){
  //   $.post('performanceratingreportinfo_proc.php', {
  //     load: true,
  //     prr_id: <?php echo $prr_id; ?>,
  //     type: "<?php echo $type; ?>"
  //   }, function(data, textStatus, xhr) {
  //     $("#tableDiv").html(data);
  //   });
  // }
  function load2(i) {

    $.post('umbra/prrDepartmentData.php', {
      dep: f(i.name)['departments'].value,
      prrc_id: <?= $_GET['prr_id'] ?>
    }, function(data, textStatus, xhr) {
      $('#DepartmentBody').html(data);
      Depshow();
    });
    return (false);
  }

  function addNew() {
    $("#dropdown_period_add").dropdown({
      showOnFocus: false
    });
    $("#dropdown_type_add").dropdown({
      showOnFocus: false
    });
    $("#modal_add").modal({
      closable: false,
      onDeny: function() {
        $(clear);
      },
      onApprove: function() {
        $.post('performanceratingreport_proc.php', {
          addNew: true,
          dropdown_period_add: $("#dropdown_period_add").dropdown("get value"),
          input_year_add: $("#input_year_add").val(),
          dropdown_type_add: $("#dropdown_type_add").dropdown("get value"),
          input_agency_add: $("#input_agency_add").val(),
          input_address_add: $("#input_address_add").val(),
        }, function(data, textStatus, xhr) {
          // $(load);
        });
      }
    }).modal("show");
  }

  function clear() {
    $("#dropdown_period_add").dropdown("clear defaults");
    $("#dropdown_type_add").dropdown("clear defaults");
    $("#input_year_add").val("");
    $("#input_agency_add").val("");
    $("#input_address_add").val("");
  }

  function stateColor(id, empId, prr_id, Scolor) {
    eventColor = event;
    $.post('umbra/PrrSaveRate.php', {
      prrList: id,
      prr_id: prr_id,
      empId: empId,
      Scolor: Scolor
    }, function(data, textStatus, xhr) {
      if (data == 1) {
        if (Scolor == "C") {
          back = "CYAN";
        } else if (Scolor == 'Y') {
          back = 'YELLOW';
        } else if (Scolor == 'W') {
          back = 'WHITE';
        }
        eventColor.srcElement.parentElement.parentElement.style.background = back;
      }
    });
  }

  function ratingModal(id, empId, prr_id) {
    $('#rating_modal').modal('show');
    $("#rating_modal").html("<center><img style='transform: scale(0.1); margin-top: -200px;' src='assets/images/loading.gif'></center>");
    $.post('umbra/ratingAjaxForm.php', {
      prrList: id,
      prr_id: prr_id,
      empId: empId
    }, function(data, textStatus, xhr) {
      if (textStatus == "success") {
        $("#rating_modal").html(data)
      } else {
        $("#rating_modal").html("<center><h1>Something went Wrong</h1></center>");
      }

    });
  }

  function adrate(i) {
    inputedData = parseFloat(i.value);
    if (inputedData > 5) {
      i.value = 5;
      $("#adjectiveRate").val("Outstanding");
    }
    if (inputedData <= 1) {
      $("#adjectiveRate").val("P");
    } else if (inputedData <= 2 && inputedData >= 0) {
      $("#adjectiveRate").val("US");
    } else if (inputedData <= 3 && inputedData >= 2) {
      $("#adjectiveRate").val("S");
    } else if (inputedData <= 4 && inputedData >= 3) {
      $("#adjectiveRate").val("VS");
    } else if (inputedData <= 5 && inputedData >= 4) {
      $("#adjectiveRate").val("O");
    } else {
      $("#adjectiveRate").val("Undefined value");
    }
  }

  function f(el) {
    return document.forms[el];
  }

  function rateDataSave(i) {
    prrList = f(i.name)['prrList'].value;
    empId = f(i.name)['empId'].value;
    prr_id = f(i.name)['prr_id'].value;
    appraisalType = f(i.name)['appraisalType'].value;
    appraisalDate = f(i.name)['appraisalDate'].value;
    numericalRating = f(i.name)['numericalRating'].value;
    adjectiveRate = f(i.name)['adjectiveRate'].value;
    remarks = f(i.name)['remark'].value;
    comments = f(i.name)['comment'].value;
    DataSub = f(i.name)['DataSub'].value;
    // console.log("rateDataSave: ", {
    //   prrList: prrList,
    //   empId: empId,
    //   prr_id: prr_id,
    //   appraisalType: appraisalType,
    //   appraisalDate: appraisalDate,
    //   numericalRating: numericalRating,
    //   adjectiveRate: adjectiveRate,
    //   remarks: remarks,
    //   comments: comments,
    //   DataSub: DataSub,
    // });


    $.post('umbra/PrrSaveRate.php', {
      prrList: prrList,
      empId: empId,
      prr_id: prr_id,
      appraisalType: appraisalType,
      appraisalDate: appraisalDate,
      numericalRating: numericalRating,
      adjectiveRate: adjectiveRate,
      remarks: remarks,
      comments: comments,
      DataSub: DataSub
    }, function(data, textStatus, xhr) {
      if (textStatus == 'success') {
        // load();
        // this.vue_prr.get_items()
        // console.log("rateDataSave: ", data);
        window.vue_prr.get_items()
        $('#rating_modal').modal('hide');
      }
    });

    return (false);

  }

  function find(i) {
    $("#tableBody tr").filter(function(index) {
      $(this).toggle($(this).text().toLowerCase().indexOf(i.value.toLowerCase()) > -1)
    });
  }

  function removePerInfo(i) {
    el = event.srcElement;
    con = confirm("Are you sure?");
    if (con) {
      $.post('umbra/PrrRemoveRate.php', {
        prrDataRemove: i
      }, function(data, textStatus, xhr) {
        if (data == 1) {
          el.parentElement.parentElement.remove();
        }
      });
    }
  }

  function addempprr(i) {
    empid = $('#empidprr').val();
    if (empid != "") {
      $.post('umbra/addemppage.php', {
        addemppage: true,
        empid: empid,
        prrid: i
      }, (data, textStatus, xhr) => {
        window.vue_prr.get_items()
      });
    }
  }
</script>
<script src="./performanceratingreportinfo.js"></script>
<style type="text/css">
  .center-align {
    text-align: center !important;
  }

  .left-align {
    text-align: left !important;
  }

  .customTable2,
  tr {
    width: 100%;
  }

  .noborder {
    border-top: 1px solid white;
    border-bottom: 1px solid white;
    border-left: 1px solid white;

  }

  .noright {
    border-right: 1px solid white;
  }
</style>