<?php $title = "Appointments"; require_once "header.php"; require_once "_connect.db.php";?>
<div id="app" style="background: white; margin-top:30px; width:95%;;margin-left:40px;padding:20px">
   <div class="ui form">
    <div style="font-size:15x;box-shadow: -0px 3px gray; height:30px;">PLANTILLA INFORMATION</div><br><br>
  <!-- appointee -->
   <!-- start -->
        <strong>Name of Appointee:</strong>
          <div class="five fields">
<br>
             <div class="field">  
              <select class="ui search dropdown" v-model.number="employees_id">
                <option value="">Employee ID</option>
                <option v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.employees_id }}</option>
              </select>
              </div>
              <div class="field">
                <input type="text" placeholder="First Name" v-model="firstName" required>
              </div>
              <div class="field">
                <input type="text"  placeholder="Middle Name" v-model="middleName">
              </div>
              <div class="field">
                <input type="text"  placeholder="Last Name" v-model="lastName" required>
              </div>
              <div class="field">
                <input type="text"  placeholder="Suffix" v-model="extName">
              </div> 
        </div>

        <!-- <div class="field">
              <div class="field">  
                  <input type="text" placeholder="Employee Address" required>
               </div>
         </div> -->
   <!-- end -->
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
                          <select class="ui search dropdown" v-model.number="plantilla_id">
                            <option value="">Postion Name</option>
                            <option v-for="Plantilla in Plantillas" :value="Plantilla.id">{{ Plantilla.position_title }}</option>
                          </select>  
                          <!-- <input type="text" placeholder="Position Name"> -->
                      </div>
                      <div class=" field">
                          <strong>Probationary Period:</strong> 
                          <input type="text" placeholder="Probationary Period" v-model="probationary_period">
                      </div>
                      
                    <div class="field">
                          <strong>Position Vacated by:</strong> 
                          <select class="ui search dropdown" v-model.number="vacated_by">
                            <option value="">Employee ID</option>
                            <option v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.lastName }} {{ Employee.firstName }}</option>
                          </select>
                    </div> 
                    <div class="two fields">
                        <div class= "field">
                            <strong>Reason of Vacancy:</strong> 
                            <select class="ui fluid search dropdown">
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
         
            <div class="five wide column">
              <div class="ui form">
                  <div class="field">
            <br>
                       <div class="field"> 
                          <strong>Supervisor:</strong> 
                          <select class="ui search dropdown" v-model.number="supervisor">
                            <option value="">Supervisor</option>
                            <option v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.lastName }} {{ Employee.firstName}}</option>
                          </select>
                          <!-- <input type="text" placeholder="Supervisor"> -->
                      </div>
                      <div class="field">
                          <strong>Supervisor's Title:</strong> 
                          <input type="text" placeholder="Supervisor's Title" v-model="sup_position" readonly>
                      </div>
                      <div class="field">
                          <strong>Next Higher Supervisor Title:</strong> 
                          <select class="ui search dropdown" v-model.number="nextInRank">
                            <option value="">Next Higher Supervisor Title</option>
                            <option v-for="Plantilla in Plantillas" :value="Plantilla.id">{{ Plantilla.position_title }}</option>
                          </select>
                      </div>
                    <div class = "two fields">
                          <div class="field">
                              <strong>Department:</strong> 
                              <input type="text"  placeholder="Department" v-model="department" readonly  >
                          </div>
                          <div class="field">
                              <strong>Department Head:</strong> 
                              <select class="ui search dropdown" v-model.number="Department_Head">
                                <option value="">Search Employee</option>
                                <option v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.lastName }} {{ Employee.firstName }}</option>
                              </select>
                          </div>
                    </div>
                </div>
              </div>
            </div>
              
                <div class="six wide column">
                     <div class="ui form">
                        <br>
                    <div class="two fields">
                       <div class="field"> 
                           <strong>Section</strong> 
                           <input type="text" placeholder="Section" v-model="section">
                        </div>
                        <div class="field"> 
                           <strong>Section Head</strong> 
                           <select class="ui search dropdown" v-model.number="Section_Head">
                            <option value="">Search Employee</option>
                            <option v-for="Employee in Employees" :value="Employee.employees_id">{{ Employee.lastName }} {{ Employee.firstName }}</option>
                          </select>
                        </div>
                    </div>
                      <div class = "two fields">
                          <div class=" field">
                                <strong>Salary Grade:</strong> 
                                   <input type="text" placeholder="Salary Grade" v-model="sg" readonly>
                          </div>
                          <div class="field">
                                <strong>Salary Rate:</strong> 
                                   <input type="number" placeholder="Salary Rate" v-model="actual_salary" readonly>
                          </div>
                       </div>
                        <div class="field"> 
                             <strong>Salary in Words:</strong> 
                             <input type="text" placeholder="Salary in Words" v-model="actual_salary_in_words" readonly>
                        </div>
                       <div class = "three fields">
                          <div class=" field">
                                <strong>Other compensation:</strong> 
                                   <input type="text" placeholder="Other compensation" v-model="other_compensation">
                          </div>
                          <div class="field">
                                <strong>Page No.:</strong> 
                                   <input type="number" placeholder="Page No." v-model="page_no">
                          </div>
                          <div class="field">
                                <strong>Item No.:</strong> 
                                   <input type="text" placeholder="Item No." v-model="item_no" readonly> 
                          </div>
                       </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
    <br>
      <div style="font-size:15x;box-shadow: -0px 3px gray; height:30px;">APPOINTMENT INFORMATION</div><br> 
       <div class="ui grid">
          <div class="three column row">
            <div class="five wide column">
                 <div class="ui form">
                       <div class="field"> 
                         <strong>Status of Appointment</strong> 
                              <select id="status" class="ui fluid search selection dropdown" v-model="status_of_appointment">
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
                                   <input type="date" v-model="date_of_appointment">
                          </div>
                          <div class="field">
                                <strong>Date of Assumption:</strong> 
                                   <input type="date" v-model="date_of_assumption">
                          </div>
                       </div>
                      <div class="field">
                            <strong>Nature of Appointment:</strong> 
                               <select id="nature" class="ui fluid search selection dropdown" v-model="nature_of_appointment">
                                <option value="">---</option>
                                <option value="original">Original</option>
                                <option value="promotion">Promotion</option>
                                <option value="transfer">Transfer</option>
                                <option value="re-employment">Re-employment</option>
                                <option value="re-appointment">Re-appointment</option>    
                                <option value="renewal">Renewal</option>    
                                <option value="demotion">Demotion</option>        
                              </select>
                      </div>
                      <div class = "two fields">
                          <div class=" field">
                                <strong>Appointing Authority:</strong> 
                                   <input type="text" placeholder="HENRY A. TEVES" v-model="head_of_agency">
                          </div>
                          <div class="field">
                                <strong>Date of Signing:</strong> 
                                   <input type="date" v-model="date_of_signing">
                          </div>
                       </div>
                    </div>
            </div>
         
            <div class="six wide column">
              <div class="ui form">
                  <div class="field">
                       
                       <div class = "two fields">
                          <div class=" field">
                                <strong>CSC Authorized Official:</strong> 
                                   <input type="text" placeholder="GINA A CRUCIO" v-model="csc_auth_official">
                          </div>
                          <div class="field">
                                <strong>Date of Signed by CSC:</strong> 
                                   <input type="date" v-model="date_signed_by_csc">
                          </div>
                       </div>

                          <div class=" field">
                                <strong>CSC MC NO.:</strong> 
                                   <input type="number" placeholder="CSC MC NO." v-model="csc_mc_no">
                          </div>

                       <div class = "two fields">
                          <div class="field">
                                <strong>Assessment Date:</strong> 
                                   <input type="date" v-model="assessment_date_from">
                          </div>
                           <div class="field">
                                <strong>To:</strong> 
                                   <input type="date" v-model="assessment_date_to">
                          </div>
                       </div>
                        <div class = "two fields">
                          <div class="field">
                                <strong>Deliberation Date:</strong> 
                                   <input type="date" v-model="deliberation_date_from">
                          </div>
                           <div class="field">
                                <strong>To:</strong> 
                                   <input type="date" v-model="deliberation_date_to">
                          </div>
                       </div>
                </div>
            </div>
          </div>
                 <div class="five wide column">
                     <div class="ui form">
                     <div class="field">
                       <div class="field"> 
                         <strong>Committee Chair:</strong> 
                         <input type="text" placeholder="JEREMIAS C GALLO" v-model="committee_chair">
                        </div>
                        <div class="field"> 
                         <strong>HRMO:</strong> 
                         <input type="text" placeholder="VERONICA GRACE P MIRAFLOR" v-model="hrmo">
                        </div>
                        <div class="field"> 
                         <strong>Cert. Funds Available:</strong> 
                         <input type="text" placeholder="CORAZON P LIRAZAN" v-model="cert_fund_available">
                        </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>   
            <br>
    <div style="font-size:15x;box-shadow: -0px 3px gray; height:30px;">PUBLICATION & OTHER INFORMATION</div><br> 
      <div class="ui grid">
          <div class="three column row">
            <div class="five wide column">
                <div class="ui form">
                    <div class="field">
                       <div class=" field"> 
                        <strong>Published At:</strong> 
                        <input type="text" placeholder="Published At" v-model="published_at">

                      </div>
                      <div class="two fields">
                        <div class= "field">
                        <strong>Probationary Date:</strong> 
                        <input type="date" v-model="probationary_date_from">
                         </div> 
                      <div>

                         <strong>To:</strong> 
                        <input type="date" v-model="probationary_date_to">
                      </div> 
                    </div>
                 </div>
                </div>
            </div>
         
            <div class="five wide column">
              <div class="ui form">
                    <div class="field">
                        <strong>Posted In:</strong> 
                        <input type="text"  placeholder="Posted In" v-model="posted_in">
                    </div> 
                    <div class="two fields">
                        <div class= "field">
                        <strong>Posted Date:</strong> 
                        <input type="date" v-model="posted_date">
                         </div> 
                      <div>

                         <strong>CSC Release Date:</strong> 
                        <input type="date" v-model="csc_release_date">
                      </div> 
                    </div>
            </div>
          </div>
              
                 <div class="six wide column">
                   <div class="ui form">
                     <div class="three fields">
                       <div class="field">
                        <strong>Government ID:</strong> 
                        <input type="text"  placeholder="Government ID" v-model="govID_type"> 
                        </div> 
                        <div class= "field">
                        <strong>ID No.:</strong> 
                        <input type="number" placeholder="ID No." v-model="govID_no">
                        </div> 
                      <div>
                         <strong>Date Issued:</strong> 
                        <input type="date" v-model="govID_issued_data">
                    </div> 
                  </div>

                  <div class="two fields">
                        <div class= "field">
                        <strong>Sworn Date:</strong> 
                        <input type="date" v-model="sworn_date">
                        </div> 
                      <div>
                         <strong>Cert. Issued Date:</strong> 
                        <input type="date"  v-model="cert_issued_date">
                    </div> 
                  </div>
                </div>
              </div>
            </div> 
    
    <div class="actions">
        <div class="ui mini approve blue button" @click="saveData()"><i class="icon check" ></i> Save</div>
    </div>

    </div>
    </div>
</div>
<script src="appointments/config.js"></script>  
<?php require_once "footer.php";?>
