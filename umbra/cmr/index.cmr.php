
 <script type="text/javascript">
  $(document).ready(function() {
    loadPeriod();
  });
 </script>



 <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon line chart"></i> COACHING AND MONITORING REPORT <span></span></h3>
   </div>
   <div class="right item">
    <div class="ui right input">
      <button class="ui icon green mini button" onclick="modal(this)" id="addPeriod" style="margin-right: 10px; width: 70px;"><i class="icon plus"></i> ADD</button>
      <!-- <button class="ui icon blue mini button" onclick="print()" style="margin-right: 10px; width: 70px;"><i class="icon print"></i> Print</button> -->
    </div>
  </div>
</div>
                        <!-- PERIOD ADDING MODAL -->
<div class="ui modal" id="addPeriodModal">
  <div class="header">Period for Coaching and Monitoring Report</div>
  <div class="content">
    <form class="ui form" name='cmrform'>
        <div class="field">
          <label>Year:</label>
          <select style="text-align: center" name="year">
            <?=opyear()?>
          </select>
        </div>
      </form>
  </div>
  <div class="actions">
    <button class="ui primary button" onclick="cmrPeriod()" >Submit</button>
    <button class="ui cancel red button">Cancel</button>
  </div>
</div>
                        <!-- end PERIOD ADDING MODAL -->
<table id="_table" class="ui very basic compact selectable small table">
  <thead>
    <tr>
      <th></th>
      <th>Period</th>
    </tr>
  </thead>
  <tbody id="cmrPeriod">
    <tr>
      <td colspan="2" style="text-align: center">
        <img src="assets/images/loading.gif" style="transform: scale(0.1);margin-top:-200px">
      </td>
    </tr>
  </tbody>
</table>

<?php 
  function opyear(){
    $syear = date("Y");
    $view = "";
    $eyear =2000; 
    while ($eyear <= $syear) {
      $view.="<option>$eyear</option>";
      $eyear++;
    }
  return $view;
  }

 ?>