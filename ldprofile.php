<?php $title = "L&D Profile"; require_once "header.php"; require_once "_connect.db.php";?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#sortYear").dropdown();

    getMinMaxYear("all");
    $("#_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
      
      if (value != "") {
        $("#year").html("");
      }
       
    });

    $(load(""));
    $("#sortYear").change(function(event) {
      var year = $(this).val();
      $(load(year));
      getMinMaxYear(year);
    });
  });

  function getMinMaxYear(year){
      if (year == "all") {
        year = "<?php 
          $sql = "SELECT MIN(year(`startDate`)) AS `minYear` FROM `personnelTrainings`";
          $result = $mysqli->query($sql);
          $row = $result->fetch_assoc();
          $minYear = $row["minYear"];
          $sql = "SELECT MAX(year(`startDate`)) AS `maxYear` FROM `personnelTrainings`";
          $result = $mysqli->query($sql);
          $row = $result->fetch_assoc();
          $maxYear = $row["maxYear"];
          echo "$minYear-$maxYear";
        ?>";
      }
    $("#year").html(year);
  }

  function load (year){
    $("#tableBody").load('ldprofile_proc.php',{
      loadTable: true,
      year: year,
    } ,
      function(){
      /* Stuff to do after the page is loaded */
    });
  }
</script>

<div class="ui container">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon list ol"></i> Learning and Development Profile</h3>
   </div>
   <div class="right item">
    <div class="ui right input">
      <div style="margin-right: 10px;">
      <select id="sortYear" class="ui floating dropdown compact"> 
        <!-- <option value="">All</option> -->
        <option value="all">All</option>
        <?php
//get year start
        require_once "_connect.db.php";
        $sql = "SELECT DISTINCT year(`startDate`) AS `years` FROM `personnelTrainings` ORDER BY `years` DESC";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
          $years = $row["years"];
          echo "<option value=\"$years\">$years</option>";
        }
//get year end
        ?>
      </select>
      </div>
      <button class="ui icon blue mini button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button>
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
  </div>
</div>
</div>
<div class="ui container" style="padding: 20px; background-color: white;">
  <h4 class="ui header printOnly" style="text-align: center;"><tt>LEARNING AND DEVELOPMENT PROFILE </tt><tt id="year"></tt></h4>
  <table id="_table" class="ui very basic compact small table">
    <thead>
      <tr>
        <th></th>
        <th>Title of Training</th>
        <th>Date</th>
        <th>Remarks</th>
        <th>Males</th>
        <th>Females</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      
    </tbody>
  </table>


</div>



<?php require_once "footer.php";?>
