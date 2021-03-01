<?php
    $title = "No DTR List";
    require_once "header.php";
?>
<div id="app_nodtr">
    <div class="ui segment" style="max-width:80%;margin:auto">
        <div class="ui secondary  menu">
            <form @submit.prevent="periodSearch()">
                <div class="item">
                    <div class="ui input" style="margin-right:10px">
                        <input type="month" v-model="period" required>
                    </div>
                    <div class="ui  ">
                        <button type="submit" class="ui button primary" id="searchPeriod">Search</button>
                    </div>
                </div>
            </form>
            <!-- <div class="right menu">
                <div class="item" style="width:400px">
                <select name="skills" multiple="" class="ui fluid dropdown">
                    <option value="">Departments</option>
                    <option v-for="(dep,index) in Departments" :value="dep.department_id">{{dep.department}}</option>
                </select>
                </div>
            </div> -->
        </div>

        <h3 style="text-align:center">List of employees who failed to submit their DTR's for the period of <template v-if="period!=''">{{period}}</template><template v-else>_______</template></h3>

        <template v-if="noDtrs.length>0">
            <table class="ui celled selectable table">
                <thead>
                    <tr>
                        <th style="width:50px;text-align: center">No.</th>
                        <th>Name</th>
                        <th style="width:300px">Letter Sent</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(noDtr,index) in noDtrs">
                        <td style="text-align: center">{{index+1}}.</td>
                        <td><a :href="'employeeinfo.v2.php?employees_id='+noDtr.employees_id" target="_blank">{{noDtr.lastName}} , {{noDtr.firstName}} {{noDtr.middleName}} {{noDtr.extName}}</td>
                        <td style="text-align: center">
                            <template v-if="noDtr.letterOfNotice">
                                  <i class="check icon green"></i>
                            </template>
                            <template v-else>
                                <button class="ui button orange" @click="letterSent(index)">Letter Sent</button>
                                <button class="ui button" @click="submitted(index)">Submitted</button>
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
        <template v-else>
            <div style="text-align: center" id="loadingMess">
                <br>
                <h2 id="loadingMess" style="color:#00000042;">Define Period</h2>
                <br>
            </div>
        </template>
    </div>
</div>
<script src="umbra/dtrManagement/config_nodtr.js"></script>
<script>
    $(document).ready(function(){
        $('.dropdown').dropdown(
            {
                fullTextSearch: true
            }
        );
    });
</script>
<?php
    require_once "footer.php";
?>