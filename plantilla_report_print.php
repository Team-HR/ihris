<?php 
  $title = "Plantilla Report"; 
  require_once "header.php";
?>

<div class="ui container" style="min-height: 6190px;">

    <center><div><img src="bayawanLogo.png" width="60px" style="right:left; margin-right: 100px">

        <p style="margin-top: -60px; margin-right: -250px"><b> Republic of the Philippines<br>
                                                            Province of Negros Oriental<br>
                                                            City of Bayawan<br> </b>
          </p>
   </div></center>

<br>
<table id="plantilla_table" class="ui teal selectable very compact small striped table" style="border: 1px solid black">
          <tr style="text-align: center; border: 1px solid black">
              <td colspan="20"><b>PLANTILLA OF PERSONNEL <br> As of echo date</b></td>
              </td>
          </tr>

          <tr style="text-align: center">
              <td rowspan="2">ITEM NO.</td>
              <td rowspan="2">POSITION TITLE</td>
              <td rowspan="2">FUNCTIONAL TITLE</td>
              <td rowspan="2">LEVEL</td>
              <td rowspan="2">SG</td>
              <td colspan ="2">ANNUAL SALARY</td>
              <td rowspan="2">STEP</td>
              <td colspan="2">AREA</td>
              <td rowspan="2">LEVEL</td>
              <td colspan="5">NAME OF INCUMBENT</td>
              <td rowspan="2">DATE OF ORIG. APPOINTMENT</td>
              <td rowspan="2">DATE OF LAST PROMOTION</td>
              <td rowspan="2">EMPLOYMENT STATUS</td>
              <td rowspan="2">ELIGIBILITY</td>          
          </tr>

          <tr style="text-align: center;">
            <td>AUTHORIZED</td>
            <td>ACTUAL</td>
            <td>CODE</td>
            <td>TYPE</td>

            <td>LAST NAME</td>
            <td>FIRST NAME</td>
            <td>MIDDLE NAME</td>
            <td>GENDER</td>
            <td>DATE OF BIRTH</td>
          </tr>

          <tr style="border: 1px solid black">
              <td colspan="20"><b>echo department</b></td>
              </td>
          </tr>
  
</table>
      

      <div>
            <p>
              <b>Total Number of Position Items</b> <u>echo number</u></p>
            </p>

            <p>
              I certify to the corrections of the entries and that above Position Items are duly approved and authorized by<br>
              the agency and in compliance to existing rules and regulations. I further certify that employees whose names <br>
              appears above are the incumbent of the position.<br>
            </p>


          </div>
</div>

