<div id="pds_education">
<div id="form_pds_education" class="ui tiny form">
    
    <button @click="goUpdate" id="btn_pds_education_update" class="ui mini teal button"><i class="icon edit"></i> Update</button>

    <div class="btns_pds_education_update ui mini buttons" style="display:none">
        <button @click="goSave" class="ui green button"><i class="icon save"></i> Save</button>
            <div class="or"></div>
        <button @click="goCancel" class="ui red button"><i class="icon trash"></i> Discard</button>
    </div>

    <h4 class="ui header">III. EDUCATIONAL BACKGROUND</h4>
    <hr>
    <table class="ui very compact small celled table">
        <thead>
            <tr class="center aligned">
                <th>Name of School</th>
                <th>Basic Educational/ Degree/ Course </th>
                <th>Period of Attendance</th>
                <th>Highest Level/Units Earned</th>
                <th>Year Graduated </th>
                <th>Scholarship/ Academic Honors Received</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="teal">Elementary</td>
            </tr>
            <template>
            <tr v-for="(elementary,i) in employee.elementary">
                <td>
                    <input v-model="elementary.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input v-model="elementary.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input v-model="elementary.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input v-model="elementary.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input v-model="elementary.year_graduated" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input v-model="elementary.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <button @click="remSchool(i,'elementary')" class="ui mini button basic icon"><i class="icon times"></i></button>
                </td>
            </tr>
            <tr v-if="numOfElementaries == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr :hidden="readonly">
                <td colspan="7">
                    <button class="ui mini basic icon button" @click="addSchool('elementary')">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="teal">Secondary</td>
            </tr>
            <tr v-for="(secondary,i) in employee.secondary">
                <td v-if="secondary.school">{{secondary.school}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="secondary.degree_course">{{secondary.degree_course}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="secondary.ed_from">{{secondary.ed_from+" - "+secondary.ed_to}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="secondary.grade_level_units">{{secondary.grade_level_units}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="secondary.year_graduated">{{secondary.year_graduated}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="secondary.scholarships_honors">{{secondary.scholarships_honors}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
            </tr>
            <tr v-if="numOfSecondaries == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr>
                <td class="teal" colspan="7">Vocational/Trade Course</td>
            </tr>
            <tr v-for="(vocational,i) in employee.vocational">
                <td v-if="vocational.school">{{vocational.school}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="vocational.degree_course">{{vocational.degree_course}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="vocational.ed_from">{{vocational.ed_from+" - "+vocational.ed_to}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="vocational.grade_level_units">{{vocational.grade_level_units}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="vocational.year_graduated">{{vocational.year_graduated}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="vocational.scholarships_honors">{{vocational.scholarships_honors}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
            </tr>
            <tr v-if="numOfVocationals == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr>
                <td class="teal" colspan="7">College</td>
            </tr>
            <tr v-for="(college,i) in employee.college">
                <td v-if="college.school">{{college.school}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="college.degree_course">{{college.degree_course}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="college.ed_from">{{college.ed_from+" - "+college.ed_to}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="college.grade_level_units">{{college.grade_level_units}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="college.year_graduated">{{college.year_graduated}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="college.scholarships_honors">{{college.scholarships_honors}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
            </tr>
            <tr v-if="numOfColleges == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr>
                <td class="teal" colspan="7">Graduate Studies</td>
            </tr>
            <tr v-for="(graduate_studies,i) in employee.graduate_studies">
                <td v-if="graduate_studies.school">{{graduate_studies.school}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="graduate_studies.degree_course">{{graduate_studies.degree_course}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="graduate_studies.ed_from">{{graduate_studies.ed_from+" - "+graduate_studies.ed_to}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="graduate_studies.grade_level_units">{{graduate_studies.grade_level_units}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="graduate_studies.year_graduated">{{graduate_studies.year_graduated}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
                <td v-if="graduate_studies.scholarships_honors">{{graduate_studies.scholarships_honors}}</td>
                <td v-else style="color:lightgrey">-- n/a --</td>
            </tr>
            <tr v-if="numOfGraduateStudies == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            </template>
        </tbody>
    </table>
</div>
</div>
<script src="pds/pds_education.js"></script>