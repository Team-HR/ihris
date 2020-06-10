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
                <th style="min-width: 300px !important;">Name of School</th>
                <th>Basic Educational/ Degree/ Course </th>
                <th>Period of Attendance</th>
                <th>Highest Level/Units Earned</th>
                <th>Year Graduated </th>
                <th>Scholarship/ Academic Honors Received</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <template>
            <tr>
                <td colspan="7" class="teal">Elementary</td>
            </tr>
            <tr v-for="(elementary,i) in educations.elementary">
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.year_graduated" :readonly="readonly" type="number" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="elementary.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td :hidden="readonly">
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
            <tr v-for="(secondary,i) in educations.secondary">
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.year_graduated" :readonly="readonly" type="number" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="secondary.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td :hidden="readonly">
                    <button @click="remSchool(i,'secondary')" class="ui mini button basic icon"><i class="icon times"></i></button>
                </td>
            </tr>
            <tr v-if="numOfSecondaries == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr :hidden="readonly">
                <td colspan="7">
                    <button class="ui mini basic icon button" @click="addSchool('secondary')">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
            <tr>
                <td class="teal" colspan="7">Vocational/Trade Course</td>
            </tr>
            <tr v-for="(vocational,i) in educations.vocational">
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.year_graduated" :readonly="readonly" type="number" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="vocational.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td :hidden="readonly">
                    <button @click="remSchool(i,'vocational')" class="ui mini button basic icon"><i class="icon times"></i></button>
                </td>
            </tr>
            <tr v-if="numOfVocationals == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr :hidden="readonly">
                <td colspan="7">
                    <button class="ui mini basic icon button" @click="addSchool('vocational')">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
            <tr>
                <td class="teal" colspan="7">College</td>
            </tr>
            <tr v-for="(college,i) in educations.college">
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.year_graduated" :readonly="readonly" type="number" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="college.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td :hidden="readonly">
                    <button @click="remSchool(i,'college')" class="ui mini button basic icon"><i class="icon times"></i></button>
                </td>
            </tr>
            <tr v-if="numOfColleges == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr :hidden="readonly">
                <td colspan="7">
                    <button class="ui mini basic icon button" @click="addSchool('college')">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
            <tr>
                <td class="teal" colspan="7">Graduate Studies</td>
            </tr>
            <tr v-for="(graduate_studies,i) in educations.graduate_studies">
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.school" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.degree_course" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.ed_period" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.grade_level_units" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.year_graduated" :readonly="readonly" type="number" placeholder="-- n/a --">
                </td>
                <td>
                    <input :class="{readOnly: readonly}" v-model="graduate_studies.scholarships_honors" :readonly="readonly" type="text" placeholder="-- n/a --">
                </td>
                <td :hidden="readonly">
                    <button @click="remSchool(i,'graduate_studies')" class="ui mini button basic icon"><i class="icon times"></i></button>
                </td>
            </tr>
            <tr v-if="numOfGraduateStudies == 0">
                <td colspan="7" style="text-align: center; color: lightgrey;"> -- N/A --</td>
            </tr>
            <tr :hidden="readonly">
                <td colspan="7">
                    <button class="ui mini basic icon button" @click="addSchool('graduate_studies')">
                        <i class="icon add"></i> Add
                    </button>
                </td>
            </tr>
            </template>
        </tbody>
    </table>
</div>
</div>
<script src="pds/pds_education.js"></script>