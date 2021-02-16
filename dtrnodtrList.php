<?php
    $title = "DTR Summary";
    require_once "header.php";
?>
<div id="app_nodtr">
    <div class="ui segment" style="max-width:80%;margin:auto">
        <div class="ui secondary  menu">
        <form @submit.prevent="periodSearch()">
            <div class="item">
                <div class="ui input" style="margin-right:10px">
                    <input type="month" v-model="period">
                </div>
                <div class="ui  ">
                    <button type="submit" class="ui button primary" >Search</button>
                </div>
            </div>
        </form>
            <div class="right menu">
                <div class="item" style="width:400px">
                <select name="skills" multiple="" class="ui fluid dropdown">
                    <option value="">Departments</option>
                    <option v-for="(dep,index) in Departments" :value="dep.department_id">{{dep.department}}</option>
                </select>
                </div>
            </div>
        </div>

        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width:250px">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(noDtr,index) in noDtrs">
                    <td>{{noDtr.lastName}} {{noDtr.firstName}} {{noDtr.middleName}}</td>
                    <td></td>
                </tr>
            </tbody>
        
        </table>

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