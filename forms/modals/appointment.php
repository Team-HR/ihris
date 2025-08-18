<!-- 
 script at: appointments/config.js
-->
<template>
    <button style="width: 150px;" class="ui mini green button" @click="editAppointmentModal()">Appointment</button>
    <div class="ui modal" id="appointment-editor-modal">
        <div class="header">
            Appointment
        </div>
        <div class="image content">
            <div class="description">
                <!-- <form @submit.prevent="">
                    <h4 class="ui dividing header" style="color: #00000066">
                        Plantilla Information
                    </h4>
                    <table class="pInfoTable" border="1" style="border-collapse: collapse;">
                        <tr>
                            <td class="tLabel" style="min-width: 150px;">Item No.:</td>
                            <td><input name="itemNo" v-model="plantillaEdit.itemNo" style="background-color: white;"></td>
                            <td class="tLabel" style="min-width: 150px;">Position:</td>
                            <td>
                                <select name="positionDropdown" class="ui fluid search selection dropdown" id="positionDropdown" v-model="plantillaEdit.position_id">
                                    <option value="">Select Position</option>
                                    <template v-for="position in positionOptions">
                                        <option :key="position.id" :value="position.id">{{position.position}}{{position.functional ? ' --- (' + position.functional + ')' : ''}}</option>
                                    </template>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tLabel">Step:</td>
                            <td><input name="step" v-model="plantillaEdit.step" type="number" min="1" max="8"></td>
                            <td class="tLabel">Department:</td>
                            <td>
                                <select name="departmentDropdown" class="ui fluid search selection dropdown" id="departmentDropdown" v-model="plantillaEdit.department_id">
                                    <option value="">Select Department</option>
                                    <template v-for="department in departmentOptions">
                                        <option :key="department.id" :value="department.id">{{department.department}}</option>
                                    </template>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tLabel">Salary Schedule:</td>
                            <td><input name="salarySchedule" value="1st Class" readonly style="background: #efefef; border: none; border: none;"></td>
                            <td class="tLabel"> Salary Grade:</td>
                            <td><input name="salaryGrade" v-model="plantillaEdit.sg" readonly style="background: #efefef; border: none;"></td>
                        </tr>
                        <tr>
                            <td class="tLabel">Monthly Salary:</td>
                            <td><input name="monthlySalary" v-model="plantillaEdit.monthlySalary" readonly style="background: #efefef; border: none;"></td>
                            <td class="tLabel">Annual Salary:</td>
                            <td><input name="annualSalary" v-model="plantillaEdit.annualSalary" readonly style="background: #efefef; border: none;"></td>
                        </tr>
                        <tr>
                            <td class="tLabel">Vacated by:</td>
                            <td><input name="vacatedByInput" :value="Plantilla['vac_lastName']+' '+Plantilla['vac_firstName']+' '+Plantilla['vac_middleName']+' '+Plantilla['vac_extName']" readonly style="background: #efefef; border: none;"></td>
                            <td class="tLabel">Reason of Vacancy:</td>
                            <td><input name="reasonForVacancyInput" :value="Plantilla['reason_of_vacancy']" readonly style="background: #efefef; border: none;"></td>
                        </tr>
                    </table>

                    <h4 class="ui dividing header" style="color: #00000066">Appointment</h4>
                    <table class="pInfoTable" border="1" style="border-collapse: collapse;">
                        <tr>
                            <td class="tLabel">Date of Appointment:</td>
                            <td><input type="date" v-model="date_of_appointment" /></td>
                            <td class="tLabel">Status of Appointment:</td>
                            <td>
                                <select id="status_of_appointment" class="ui fluid search selection dropdown" v-model="status_of_appointment">
                                    <option value="">---</option>
                                    <option value="elective">Elective</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="casual">Casual</option>
                                    <option value="co-term">Co-term</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="contactual">Contractual</option>
                                    <option value="substitute">Substitute</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="tLabel">Nature of Appointment:</td>
                            <td>
                                <select id="nature_of_appointment" class="ui search dropdown" v-model="nature_of_appointment">
                                    <option value="">---</option>
                                    <option value="original">Original</option>
                                    <option value="promotion">Promotion</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="re-employment">Re-employment</option>
                                    <option value="re-appointment">Re-appointment</option>
                                    <option value="renewal">Renewal</option>
                                    <option value="demotion">Demotion</option>
                                </select>
                            </td>
                            <td class="tLabel">Office Assignment:</td>
                            <td><input type="text" v-model="office_assignment" /></td>
                        </tr>
                        <tr>
                            <td class="tLabel">HRMPSB Chairman:</td>
                            <td>
                                <select id="committee_chair" class="ui search dropdown" v-model="committee_chair">
                                    <option value="">Search Name</option>
                                    <option v-for="(comChair,index) in All_Employees" :value="comChair.employees_id">
                                        {{ comChair.lastName }} {{ comChair.firstName }}
                                    </option>
                                </select>
                            </td>
                            <td class="tLabel">Probation Period:</td>
                            <td><input type="text" v-model="probationary_period" /></td>
                        </tr>
                        <tr>
                            <td class="tLabel" colspan="4">Assessment Date</td>
                        </tr>
                        <tr>
                            <td class="tLabel" style="text-align: right;">From:</td>
                            <td><input type="date"></td>
                            <td class="tLabel" style="text-align: right;">To:</td>
                            <td><input type="date"></td>
                        </tr>
                        <tr>
                            <td class="tLabel">Deliberation Date:</td>
                            <td><input type="date" v-model="deliberation_date_from" /></td>
                            <td class="tLabel">Sworn Date:</td>
                            <td><input type="date" v-model="deliberation_date_from" /></td>
                        </tr>
                    </table>

                    <h4 class="ui dividing header" style="color: #00000066">
                        Publication Info
                    </h4>
                    <table class="pInfoTable" border="1" style="border-collapse: collapse;">
                        <tr>
                            <td class="tLabel" style="width: 150px;">Published at:</td>
                            <td>
                                <input type="text" v-model="published_at" />
                            </td>
                            <td class="tLabel" style="width: 150px;">Posted in:</td>
                            <td>
                                <input type="text" v-model="posted_in" />
                            </td>
                        </tr>
                        <tr>
                            <td class="tLabel" colspan="4">Posted Date:</td>
                        </tr>
                        <tr>
                            <td class="tLabel" style="text-align: right;">From:</td>
                            <td>
                                <input type="date" v-model="posted_date_from" />
                            </td>
                            <td class="tLabel" style="text-align: right;">To:</td>
                            <td>
                                <input type="date" v-model="posted_date_to" />
                            </td>
                        </tr>
                    </table>

                    <h4 class="ui dividing header" style="color: #00000066">
                        Other Info
                    </h4>
                    <table class="pInfoTable" border="1" style="border-collapse: collapse;">
                        <tr>
                            <td class="tLabel" style="width: 150px;">Type of Gov ID:</td>
                            <td>
                                <input type="text" v-model="govId_type" />
                            </td>
                            <td class="tLabel" style="width: 150px;">Gov ID No.:</td>
                            <td>
                                <input type="text" v-model="govId_no" />
                            </td>
                        </tr>
                        <tr>
                            <td class="tLabel">Date Issued:</td>
                            <td>
                                <input type="date" v-model="govId_issued_date" />
                            </td>
                            <td class="tLabel">Address :</td>
                            <td>
                                <input type="text" v-model="address" />
                            </td>
                        </tr>
                    </table>
                </form> -->
            </div>
        </div>
        <div class="actions">
            <button class="ui basic deny button">
                Cancel
            </button>
            <button class="ui positive right labeled icon button">
                Save & Print
                <i class="print icon"></i>
            </button>
        </div>
    </div>
</template>