<?php $title = "Position Description Form DBM-CSC Form No.2"; require_once "header.php"; require_once "_connect.db.php";?>
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
  <tr class="label">
    <th colspan="4">20. BRIEF DECRIPTION OF THE GENERAL FUNCTION OF THE POSITION(Job Summary)</th>
  </tr>
      <th colspan="4"><center><i style=" font-size:11px">php echo brief description</i></center>
  </tr>  
  <tr class="label">
    <th colspan="4">21.QUALIFICATION STANDARDS</th>
  </tr>
  <tr class="label" style="text-align: center">
    <th style="text-indent: 10px">21a. Education</th>
    <th style="width:2px;">21b. Experience</th>
    <th style="width:2px">21c. Training</th>
      <th style="width:2px">21d. Eligibility</th>
  </tr>
  <tr>
          <td style="width:15em; font-size:12px">php echo completion of ___-<br>
                php echo required/non required<br>
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

  </tr>
  <tr class="label">
    <th colspan="3" style="text-indent: 10px">17.a. Internal</th>
      <th style="width:2px; text-align: center">Competency Level</th>
  </tr>
  <tr>
          <td colspan="3"style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
            </td>

            <td style="width:12em;  font-size:12px">General Public<br>
               Other Agencies<br>
               Others(Please Specify)<br>
            </td>

  </tr>
    <tr class="label">
    <th colspan="3" style="text-indent: 10px">17.a. Internal</th>
      <th style="width:2px; text-align: center">Competency Level</th>
  </tr>
  <tr>
          <td colspan="3"style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
            </td>

            <td style="width:12em;  font-size:12px">General Public<br>
               Other Agencies<br>
               Others(Please Specify)<br>
            </td>

  </tr>
    <tr class="label">
    <th colspan="3" style="text-indent: 10px">17.a. Internal</th>
      <th style="width:2px; text-align: center">Competency Level</th>
  </tr>
<tr>
        <td style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
        </td>

        <td colspan="2"style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
        </td>

        <td style="width:12em;  font-size:12px">General Public<br>
               Other Agencies<br>
               Others(Please Specify)<br>
        </td>

  </tr>
  <tr>
        <td style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
        </td>

        <td colspan="2"style="width:15em; font-size:12px">Executive / Managerial<br>
                Supervisors<br>
                Non-Supervisors<br>
                Staff<br>
        </td>

        <td style="width:12em;  font-size:12px">General Public<br>
               Other Agencies<br>
               Others(Please Specify)<br>
        </td>

  </tr>

  <tr class="label">
    <th colspan="3" style="text-indent: 10px">17.a. Internal</th>
      <th style="width:2px; text-align: center">Competency Level</th>
  </tr>

</table>
    <div style="float:right; margin-top:-15px; ">
      
      Page 1 of 2

    </div>
</body>
</html>


<?php require_once "footer.php";?>
