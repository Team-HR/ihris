<?php 
  $title = "Plantilla"; 
  require_once "header.php";
?>
<script type="text/javascript">


var dept_filters = "";


$(document).ready(function () {

        $("#disBtn").submit(function (e) {

          
            e.preventDefault();

            //Disable disBtn
            $("#publishBtn").attr("disabled", true);
            return true;

        });
});


function publish() {
  var x = document.getElementById("publishBtn");
  x.disabled = true;
}

 $("#disBtn").submit(function (e) {

            //Stop submitting form
            e.preventDefault();

            //Disable disBtn
            $("#publishBtn").attr("disabled", true);
            return true;

    });


  $(document).ready(function() {
    var loading = $("#loading_el");

    $("#addReason").dropdown();
    $("#addIncumbent").dropdown();
    $("#addDept").dropdown();
    $("#addPos").dropdown();
    $("#addVacator").dropdown();
    $("#addAbolish").dropdown();
    $("#addSupervisor").dropdown();

    $("#data_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#plantilla_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    $(load);
  });
  
  function load(){
    $("#tableContent").load("plantilla_vacantpos_proc.php",{
      load: true
    });
  }
  
 
</script>
<!-- savae msg alert start -->

<!----load table data---->
<div class="ui segment" :class="loader">
  <div class="ui container">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="briefcase icon"></i>Vacant Positions</h3>
    </div>
    <div class="right item">
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
  
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="data_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
    </div>
  </div>
<div class="ui container" style="min-height: 6190px;">
<table id="plantilla_table" class="ui teal selectable very compact small striped table">
  <thead>
    <tr style="text-align: center;">
    
      <th rowspan="2">Item No.</th>
      <th rowspan="2">Position</th>
      <th rowspan="2">Department</th>
      <th rowspan="2">Vacated By</th>
      <th rowspan="2">Options</th>
   
    </tr>
  </thead>
        <tbody id="tableContent">
              <tr id="loading_el">
              <td colspan="20" style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;"><!-- FETCHING DATA... -->
                <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
                <br>
                <br>
                <span>fetching data...</span>
              </td>
            </tr>
        </tbody>
</table>

  </div>
    </div>
  </div>
</div>
<?php 
  require_once "footer.php";
?>
