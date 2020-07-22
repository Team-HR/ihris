<?php $title = "Position Description Form DBM-CSC Form No.1"; require_once "header.php"; require_once "_connect.db.php";?>
<style type="text/css">
<style>
input {
  width: 13px;
  height: 10px;
  padding: 0px;
  margin:0;
  vertical-align: bottom;
  position: relative;
  top: -1px;
  *overflow: hidden;
}
label{
  font-size:12px
}
tr.label{
  background-color: gray;
  border: 1px solid black;
  font-size:11px
}
th.label{
  background-color: gray;
   font-size:11px
}
</style>

<div class="ui container">
  <div class="ui container" style="background-color: white;padding:10px; width: 800px">

<table  class="ui celled structured table" style="border: 3px solid black">
  <tr>
    <th  colspan="3" rowspan="2">    <center>
                             Republic of the Philippines<br>
                            POSITION DESCEIPTION FORM<br>
                            DBM - CSC Form No.1<br>
                            <i style="font-size: 10px">(Revised Version No.1 , s.2017)<i>
            </center></th>
    <th colspan="3" class="label">         1. POSITION TITLE (as approved by authorized agency)<br>
                                                    with parenthetical title</th>
  </tr>
  <tr>
    <td colspan="3">$php echo salary grade</td>
  </tr>

  <tr class="label">
    <th colspan="3" >2. ITEM NUMBER</th>
    <th  colspan="3">3. SALARY GRADE</th>
  </tr>
  <tr>
    <td colspan="3">$php echo position item_number</td>
    <td  colspan="3">$php echo position title</td>
  </tr>

<tr class="label">
    <th colspan="6">4. FOR LOCAL GOVERNMENT POSITION, ENUMERATE GOVERNMENTAL UNIT AND CLASS
</tr>
  <tr>
            <td colspan="2"><input type="checkbox"class="w3-check"><label> Province</label><br>
            <input type="checkbox"class="w3-check"><label> City</label><br>
            <input type="checkbox"class="w3-check"><label>Municipality</label></td>
 
            <td colspan="2"><input type="checkbox"class="w3-check"><label>1st Class</label><br>
            <input type="checkbox"class="w3-check"><label>2nd Class</label><br>
            <input type="checkbox"class="w3-check"><label>3rd Class</label><br>
            <input type="checkbox"class="w3-check"><label>4th Class</label></td>

            <td colspan="2"><input type="checkbox"class="w3-check"><label>5th Class</label><br>
            <input type="checkbox"class="w3-check"><label>6th Class</label><br>
            <input type="checkbox"class="w3-check"><label>Specialist</label></td>
  </tr>
 <tr class="label">
    <th colspan="3">5.DEPARTMENT, CORPORATION OR AGENCY/LOCAL GOVERNMENT </th>
    <th  colspan="3">6.BUREAU OR OFFICE </th>
  </tr>
 <tr>
    <td colspan="3">$php echo Local Government Unit</td>
    <td colspan="3">$php echo office</td>
  </tr>
<tr class="label">
    <th colspan="3">7.DEPARTMENT/ BRANCH /DIVISION </th>
    <th  colspan="3">8.WORKSTATION / PLACE OF WORK </th>
</tr>
<tr>
    <td colspan="3">$php echo department</td>
    <td colspan="3">$php echo workstation</td>
</tr>

<tr class="label">
    <th >9.PRESENT APPROP ACT </th>
    <th>10.PREVIOUS APPROP ACT </th>
    <th>11.SALARY AUTHORIZED </th>
    <th colspan="3">12. OTHER COMPENSATION </th>
</tr>
<tr>
    <td></td>
    <td></td>  
     <td></td> 
    <td colspan="3"></td>
</tr>
<tr class="label">
    <th colspan="3">13. POSITION TITLE OF IMMEDIATE SUPERVISOR </th>
    <th  colspan="3">14.POSITION TITLE OF NEXT HIGHER SUPERVISOR  </th>
</tr>
<tr>
    <td colspan="3">$php echo immediate supervisor</td>
    <td colspan="3">$php echo position of supervisor</td>
</tr>
  <tr class="label">
    <th colspan="6">15. POSITION TITLE, AND ITEM OF THOSE WHO DIRECTLY SUPERVISED
  </tr>
  <tr >
    <th colspan="6"><center><i style=" font-size:11px">(if more than seven (7) list only by their item numbers and titles)</i></center>
  </tr>
  <tr class="label" style="text-align:center">
    <th colspan="3">POSITION TITLE </th>
    <th colspan="3">ITEM NUMBER</th>
</tr>
<tr style="height:">
    <td colspan="3" style="text-align: center">$php echo position title</td>
    <td colspan="3" style="text-align: center">$php echo item number</td>

</tr>
<tr rowspan="3" class="label">
    <th colspan="6">16. MACHINE, EQUIPMENT, TOOLS, ETC., USED REGULARY IN PERFORMANCE OF WORK
</tr>
  <tr>
    <td colspan="6"><center>$php echo used machines/equipment</center></td>
  </tr>
<tr rowspan="6" class="label">
    <th colspan="6">17.CONTACTS / CLIENTS/ STAKEHOLDERS
</tr>
<tr class="label" style="text-align: center">
    <th style="text-indent: 10px">17.a. Internal</th>
    <th style="width:2px;">Occasional</th>
    <th style="width:2px">Frequent</th>
    <th>17b.External</th>
    <th style="width:2px">Occasional</th>
    <th style="width:2px">Frequent</th>
</tr>

 <tr>
          <td style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            </td>

            <td style="width:12em;  font-size:12px">General Public<br>
               Other Agencies<br>
               Others(Please Specify)<br>
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            <label>______</label>
          
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
             <label>______</label>
          
            </td>


  </tr>
<tr class="label">
    <th colspan="6">18. WORKING CONDITION
</tr>
 <tr>
          <td style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            </td>

            <td style="width:5px; text-align: center"><input type="checkbox"class="w3-check"><br>
            <input type="checkbox"class="w3-check"><br>
            </td>

            <td colspan="3" style="width:12em; font-size:12px">
               Others(Please Specify)<br>
            </td>


  </tr>

<tr class="label">
    <th colspan="6">19. BRIEF DESCRIPTION OF THE GENERAL FUNCTIO OF THE UNIT OR SECTION
</tr>
<tr>
    <td colspan="6">echo brief description of function</td>
</tr>
 

</table>
    <div style="float:right; margin-top:-15px; ">
      
      Page 1 of 2

    </div>
</body>
</html>


<?php require_once "footer.php";?>
