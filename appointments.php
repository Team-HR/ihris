<?php $title = "Appointments"; require_once "header.php"; require_once "_connect.db.php";?>

<div id="app">
<div class="" style="background: white; margin-top:30px; width:1400px;margin-left:30px;padding:20px">

  <div style="font-size:30px;">Personnel Information</div><br><br>

<div class="ui form">

  <div style="font-size:15x;box-shadow: -0px 3px gray; height:30px;">APPOINTMENT</div><br><br>

         <!-- appointee -->
              <!-- start -->
               <strong>Name of Appointee:</strong>
            <div class="five fields">
                <br>
               <div class="field">  
               <select class="ui search dropdown" v-model='employees_id' @change="fillEmp()">
                  <option value="">ID</option>
                  <option  v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.employees_id }} </option>
                </select>
              </div>
              <div class="field">
                <input type="text" v-model='firstName' placeholder="First Name">
              </div>
              <div class="field">
                <input type="text" v-model='middleName' placeholder="Middle Name">
              </div>
              <div class="field">
                <input type="text" v-model='lastName'  placeholder="Last Name">
              </div>
              <div class="field">
                <input type="text" v-model='extName' placeholder="Suffix">
              </div> 
            </div>
<br>    
<br>          <!-- end -->
<div style="font-size:15px; box-shadow: -0px 3px gray; height:30px;">PLANTILLA</div>
 <br>

         <!-- plantilla -->
              <!-- start -->
<div class="ui grid">
  <div class="three column row">
    <div class="five wide column">
        <div class="ui form">
            <div class="field">
                <br>
               <div class=" field"> 
                <strong>Position Name:</strong> 
                <select class="ui search dropdown" v-model='employees_id' @change="fillPlantilla()">
                  <option value="">Position Name</option>
                  <option v-for="Plantilla in Plantillas" :value='Plantilla.id'>{{ Plantilla.position_title  }}</option>
                </select>
              </div>
              <div class=" field">
                <strong>Rate/Month:</strong> 
                <input type="text" placeholder="Rate/Month" readonly>
              </div>
              <div class="field">
                <strong>Department:</strong> 
                <input type="text"  placeholder="Department" readonly>
              </div>
              <div class="field">
                <strong>Item No.:</strong> 
                <input type="text"  placeholder="Item No." readonly>
              </div>
              <div class="field">
                <strong>Position Vacated by:</strong> 
                <input type="text"  placeholder="Position Vacated by" >
              </div> 
            </div>
        </div>
    </div>
 
    <div class="five wide column">
      <div class="ui form">
          <div class="field">
                <br>
               <div class="field"> 
                <strong>Salary Grade:</strong> 
                <input type="text" placeholder="Salary Grade" readonly> 
              </div>
              <div class="field">
                <strong>Annual Rate:</strong> 
                <input type="text" placeholder="Annual Rate" readonly>
              </div>
              <div class="field">
                <strong>Section:</strong> 
                <input type="text"  placeholder="Section" readonly>
              </div>
              <div class="field">
                <strong>Page No.:</strong> 
                <input type="number"  placeholder="Page No." readonly>
              </div>


        <div class="two fields">
                <div class= "field">
                <strong>Reason of Vacancy:</strong> 
                <select class="ui compact dropdown">
                  <option value="">---</option>
                  <option value="transfer">Transfer</option>
                  <option value="promotion">Promotion</option>
                  <option value="retirement">Retirement</option>
                   <option value="others">Others</option>    
                </select>
                 </div> 
              <div>
                 <strong>-</strong> 
                <input type="text"  placeholder="If others pls specify">
              </div> 
            </div>
        </div>
    </div>
  </div>
      
         <div class="six wide column">
             <div class="ui form">
             <div class="field">
                <br>
               <div class="field"> 
                 <strong>Status of Appointment</strong> 
                      <select id="status" class="ui compact dropdown">
                        <option value="">---</option>
                        <option value="elective">Elective</option>
                        <option value="permanent">Permanent</option>
                        <option value="casual">Casual</option>
                        <option value="co-term">Co-term</option>
                        <option value="temporary">Temporary</option>    
                        <option value="contactual">Contractual</option>    
                        <option value="substitute">Substitute</option>        
                      </select>
                </div>
              <div class = "two fields">
                  <div class=" field">
                        <strong>Date of Appointment:</strong> 
                           <input type="date">
                  </div>
                  <div class="field">
                        <strong>Date of Assumption:</strong> 
                           <input type="date">
                  </div>
               </div>
              <div class="field">
                    <strong>Nature of Appointment:</strong> 
                       <select id="nature" class="ui compact dropdown">
                        <option value="">---</option>
                        <option value="elective">Original</option>
                        <option value="permanent">Promotion</option>
                        <option value="casual">Transfer</option>
                        <option value="co-term">Re-employment</option>
                        <option value="temporary">Re-appointment</option>    
                        <option value="contactual">Renewal</option>    
                        <option value="substitute">Demotion</option>        
                      </select>
             </div>
               <div class="field">
                    <strong>Legal Document:</strong> 
                             <input type="text">
              </div>
              <div class="field">
                    <strong>Memo for the legality of the appointing officer:</strong> 
                             <input type="text">
              </div>
            </div>
          </div>
        </div>

  <div class="eight wide column">
      <div class="ui form">
        <div class="field">
                <br>
              <div class = "two fields">
                  <div class=" field">
                  <!----PYRDE HENRY A TEVES!---->
                        <strong>Head of Agency:</strong> 
                           <input type="text">
                  </div>
                  <div class="field">
                        <strong>Date of signing:</strong> 
                           <input type="date">
                  </div>
               </div>
              <div class = "two fields">
                  <div class=" field">
                    <!---- GINA A. CRUCIO!---->
                        <strong>CSC Authorized Official:</strong> 
                           <input type="text">
                  </div>
                  <div class="field">
                        <strong>Date of signed by CSC:</strong> 
                           <input type="date">
                  </div>
               </div>
               <div class="field">
                    <strong>CSC MC No.:</strong> 
                             <input type="text">
              </div>
            
             <br>
              <div class = "two fields">
                  <div class=" field">
                        <strong>Published at:</strong> 
                           <input type="text">
                  </div>
                  <div class="field">
                        <strong>Date of Publication:</strong> 
                           <input type="date">
                  </div>
              </div>
           
                  <div class=" field">
                        <strong>Personnel Selection Board</strong> 
                           <input type="text">
                  </div>
                 
             </div>
            </div>
    </div>    

    <div class="eight wide column">
      <div class="ui form">
        <div class="field">
                <br>
              <div class = "two fields">
                  <div class=" field">     
                  <!---- Personnel Selection Board !---->
                        <strong>Screening Body:</strong> 
                           <input type="text">
                  </div>
                  <div class="field">
                        <strong>Date of Screening:</strong> 
                           <input type="date">
                  </div>
               </div>
               <!---- JEREMIAS C GALLO NI DRI !---->
                 <div class=" field">
                        <strong>Committee Chair:</strong> 
                           <input type="text">
                 </div>

                  <div class=" field">
                        <strong>Notation:</strong> 
                        <br>
                    <div>
                      <table class="w3-table w3-bordered">
                        <tbody>
                          <tr>
                            <td style="width:100px; text-align: center;"><input type="checkbox" value="1" class="w3-check"></td>
                            <td>
                             Effective not earlier than the date of publication and subject for probationary period of six(6) months.
                            </td>
                          </tr>
                           <tr>
                            <td style="width:100px; text-align: center;"><input type="checkbox" value="1" class="w3-check"></td>
                            <td>
                             Provided that the salary is allowable under the existing laws.
                            </td>
                          </tr>
                           <tr>
                            <td style="width:100px; text-align: center;"><input type="checkbox" value="1" class="w3-check"></td>
                            <td>
                             Subject for official verification of her/his CS eligibility and provided that there is no pending administrative case filed against the proposed appointee.
                            </td>
                          </tr>
                          <tr>
                            <td style="width:100px; text-align: center;"><input type="checkbox" value="1" class="w3-check"></td>
                            <td>
                             Co-terminous with the appointing authority.
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                 </div>
                  <div class="five wide field">
                        <strong>CSC Release Date:</strong> 
                           <input type="date">
                 </div>
  
               </div>
              </div>
        </div>

     
              <div class="actions" style="margin-top:30px;">
                <div class="ui deny button mini">
                  Cancel
                </div>
                <div class="ui approve blue right labeled icon button mini">
                  Save
                  <i class="checkmark icon"></i>
                </div>
              </div>

  </div>


              </div>
            </div>      
          </div>
        </div>     
      </div>
    </div>
  </div>
</div>
</div>
<script src="appointments/config.js"></script>
<?php require_once "footer.php";?>
