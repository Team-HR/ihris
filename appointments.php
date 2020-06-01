<div id="app" style="background: white;">
   <div class="ui form">
    <div style="font-size:15x;box-shadow: -0px 3px gray; height:30px;">PLANTILLA INFORMATION</div><br><br>
  <!-- appointee -->
   <!-- start -->
        <strong>Name of Appointee:</strong>
          <div class="five fields">
<br>
             <div class="field">  
                <input id="" type="number" placeholder="Employee ID">
              </div>
              <div class="field">
                <input id="" type="text" placeholder="First Name">
              </div>
              <div class="field">
                <input id="" type="text"  placeholder="Middle Name">
              </div>
              <div class="field">
                <input id="" type="text"  placeholder="Last Name">
              </div>
              <div class="field">
                <input id="" type="text"  placeholder="Suffix">
              </div> 
        </div>
        <div class="field">
              <div class="field">  
                  <input id="" type="text" placeholder="Employee Address">
               </div>
         </div>
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
                          <input id="" type="text" placeholder="Position Name">
                      </div>
                      <div class=" field">
                          <strong>Probationary Period:</strong> 
                          <input id="" type="text" placeholder="Probationary Period">
                      </div>
                      <div class="two fields">
                        <div class= "field">
                            <strong>Probationary Date:</strong> 
                            <input id="" type="date" >
                        </div> 
                        <div>
                             <strong>To:</strong> 
                             <input id="" type="date">
                        </div> 
                     </div>
                    <div class="field">
                          <strong>Position Vacated by:</strong> 
                          <input id="" type="text"  placeholder="Position Vacated by">
                    </div> 
                    <div class="two fields">
                        <div class= "field">
                            <strong>Reason of Vacancy:</strong> 
                            <select id="" class="ui fluid search selection dropdown">
                              <option value="">---</option>
                              <option value="transfer">Transfer</option>
                              <option value="promotion">Promotion</option>
                              <option value="retirement">Retirement</option>
                               <option value="others">Others</option>    
                            </select>
                         </div> 
                      <div>
                           <strong>-</strong> 
                          <input id="" type="text"  placeholder="If others pls specify">
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
                          <input id="" type="text" placeholder="Supervisor">
                      </div>
                      <div class="field">
                          <strong>Supervisor's Title:</strong> 
                          <input id="" type="text" placeholder="Supervisor's Title">
                      </div>
                      <div class="field">
                          <strong>Next Higher Supervisor Title:</strong> 
                          <input id="" type="text"  placeholder="Next Higher Supervisor Title">
                      </div>
                      <div class="field">
                          <strong>Department:</strong> 
                          <input id="" type="text"  placeholder="Department">
                      </div>
                      <div class="field">
                          <strong>Department Head:</strong> 
                          <input id="" type="text"  placeholder="Department Head">
                      </div>
                </div>
              </div>
            </div>
              
                <div class="six wide column">
                     <div class="ui form">
                        <br>
                       <div class="field"> 
                           <strong>Section</strong> 
                           <input id="" type="text" placeholder="Section">
                        </div>
                        <div class="field"> 
                           <strong>Section Head</strong> 
                           <input id="" type="text" placeholder="Section Head">
                        </div>
                      <div class = "two fields">
                          <div class=" field">
                                <strong>Salary Grade:</strong> 
                                   <input id="" type="text" placeholder="Salary Grade">
                          </div>
                          <div class="field">
                                <strong>Salary Rate:</strong> 
                                   <input id="" type="number" placeholder="Salary Rate">
                          </div>
                       </div>
                        <div class="field"> 
                             <strong>Salary in Words:</strong> 
                             <input id="" type="text" placeholder="Salary in Words">
                        </div>
                       <div class = "three fields">
                          <div class=" field">
                                <strong>Other compensation:</strong> 
                                   <input id="" type="text" placeholder="Other compensation">
                          </div>
                          <div class="field">
                                <strong>Page No.:</strong> 
                                   <input id="" type="number" placeholder="Page No.">
                          </div>
                          <div class="field">
                                <strong>Item No.:</strong> 
                                   <input id="" type="number" placeholder="Item No.">
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
                              <select id="status" class="ui fluid search selection dropdown">
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
                                   <input id="" type="date">
                          </div>
                          <div class="field">
                                <strong>Date of Assumption:</strong> 
                                   <input id="" type="date">
                          </div>
                       </div>
                      <div class="field">
                            <strong>Nature of Appointment:</strong> 
                               <select id="nature" class="ui fluid search selection dropdown">
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
                    </div>
            </div>
         
            <div class="six wide column">
              <div class="ui form">
                  <div class="field">
                       <div class = "two fields">
                          <div class=" field">
                                <strong>Appointing Authority:</strong> 
                                   <input id="" type="text" placeholder="HENRY A. TEVES">
                          </div>
                          <div class="field">
                                <strong>Date of Signing:</strong> 
                                   <input id="" type="date">
                          </div>
                       </div>
                       <div class = "two fields">
                          <div class=" field">
                                <strong>CSC Authorized Official:</strong> 
                                   <input id="" type="text" placeholder="GINA A CRUCIO">
                          </div>
                          <div class="field">
                                <strong>Date of Signed by CSC:</strong> 
                                   <input id="" type="date">
                          </div>
                       </div>
                       <div class = "three fields">
                          <div class=" field">
                                <strong>CSC MC NO.:</strong> 
                                   <input id="" type="number" placeholder="CSC MC NO.">
                          </div>
                          <div class="field">
                                <strong>Assessment Date:</strong> 
                                   <input id="" type="date">
                          </div>
                           <div class="field">
                                <strong>Deliberation Date:</strong> 
                                   <input id="" type="date">
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
                         <input id="" type="text" placeholder="JEREMIAS C GALLO">
                        </div>
                        <div class="field"> 
                         <strong>HRMO:</strong> 
                         <input id="" type="text" placeholder="VERONICA GRACE P MIRAFLOR">
                        </div>
                        <div class="field"> 
                         <strong>Cert. Funds Available:</strong> 
                         <input id="" type="text" placeholder="CORAZON P LIRAZAN">
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
                        <input id="" type="text" placeholder="Published At">

                      </div>
                      <div class="two fields">
                        <div class= "field">
                        <strong>Probationary Date:</strong> 
                        <input id="" type="date" >
                         </div> 
                      <div>

                         <strong>To:</strong> 
                        <input id="" type="date">
                      </div> 
                    </div>
                 </div>
                </div>
            </div>
         
            <div class="five wide column">
              <div class="ui form">
                    <div class="field">
                        <strong>Posted Date:</strong> 
                        <input id="" type="text"  placeholder="Posted Date">
                    </div> 
                    <div class="two fields">
                        <div class= "field">
                        <strong>Posted Date:</strong> 
                        <input id="" type="date" >
                         </div> 
                      <div>

                         <strong>CSC Release Date:</strong> 
                        <input id="" type="date">
                      </div> 
                    </div>
            </div>
          </div>
              
                 <div class="six wide column">
                   <div class="ui form">
                     <div class="three fields">
                       <div class="field">
                        <strong>Government ID:</strong> 
                        <input id="" type="text"  placeholder="Government ID">
                        </div> 
                        <div class= "field">
                        <strong>ID No.:</strong> 
                        <input id="" type="number" placeholder="ID No.">
                        </div> 
                      <div>
                         <strong>Date Issued:</strong> 
                        <input id="" type="date"  >
                    </div> 
                  </div>

                  <div class="two fields">
                        <div class= "field">
                        <strong>Sworn Date:</strong> 
                        <input id="" type="date" >
                        </div> 
                      <div>
                         <strong>Cert. Issued Date:</strong> 
                        <input id="" type="date"  >
                    </div> 
                  </div>
                </div>
              </div>
            </div> 
    
    <div class="actions">
        <div class="ui mini approve blue button"><i class="icon check"></i> Save</div>
    </div>

    </div>


    </div>
</div>  
