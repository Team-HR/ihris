<?php $title = "Request and Communications";
require_once "header.php";
require_once "_connect.db.php"; ?>
<div id="app" style="padding: 20px;">
<div class="ui fluid container">
    <div class="ui borderless blue inverted mini menu">
        <div class="left item" style="margin-right: 0px !important;">
            <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                <i class="icon chevron left"></i> Back
            </button>
        </div>
        <div class="item">
            <h3><i class="icon fax"></i> Requests and Communications</h3>
        </div>
        <div class="right item">
            <div class="ui right input">
                <button class="ui icon mini green button" onclick="addModalFunc()" style="margin-right: 5px;"><i class="icon plus"></i>Add</button>
                <div style="padding: 0px; margin: 0px; margin-right: 5px;">
                    <select id="sortYear" class="ui floating dropdown compact">
                        <option value="">Filter by Year</option>
                        <option value="all">All</option>
                        <option value="$years">$years</option>
                    </select>
                </div>
                <div class="ui icon fluid input" style="width: 300px;">
                    <input id="table_search" type="text" placeholder="Search...">
                    <i class="search icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="ui compact small segment">
        <button id="clearFilter" style="display: none;" class="ui mini button">Clear</button>
        <div class="ui multiple dropdown" v-model="department_id">
            <input type="hidden" name="filters">
            <i class="icon filter"></i>
            <span class="text">Select Department/s to filter</span>
            <div class="menu">
                <div class="ui icon search input">
                    <i class="search icon"></i>
                    <input type="text" placeholder="Search tags...">
                </div>
                <div class="divider"></div>
                <div class="header">
                    <i class="tags icon"></i>
                    Select Department/s
                </div>
                <div class="scrolling menu">
                    <div class='item' data-value='0'>All</div>
                    <div class='item' data-value='1'>1</div>
                    <div class='item' data-value='2'>2</div>
                    <div class='item' data-value='3'>3</div>
                </div>
            </div>
        </div>
    </div>
    <table class="ui selectable striped structured celled very compact table" style="font-size: 12px;">
        <thead>
            <tr class="ui center aligned">
                <th>Control No.</th>
                <th>Date Recieved</th>
                <th>Source</th>
                <th>Department/s</th>
                <th>Subject/Training</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Venue</th>
                <th>Personnel/s</th>
                <th>Type</th>
                <th>Options</th>
            </tr>
        </thead>
            <template v-for="comm in comms" :key="comm.id">
                <tr class="valigntop">
                    <td class="nowrap">{{ comm.control_number }}</td>
                    <td class="nowrap">{{ comm.date_received }}</td>
                    <td>{{ comm.source?comm.source:'--None--' }}</td>
                    <td>
                        <span v-if="comm.departments_involved == ''">--None--</span>
                        <ul class="ui list">
                            <li v-for="department in comm.departments_involved">{{department}}</li>
                        </ul>
                    </td>
                    <td>{{ comm.subject }}</td>
                    <td class="nowrap">{{ comm.start_date }}</td>
                    <td class="nowrap">{{ comm.end_date }}</td>
                    <td>{{ comm.venue }}</td>
                    <td class="nowrap">
                        <span v-if="comm.personnels_involved == ''">--None--</span>
                        <ol class="ui list">
                            <li v-for="employee in comm.personnels_involved">{{employee}}</li>
                        </ol>
                    </td>
                    <td>{{ comm.type?comm.type:"--N/A--" }}</td>
                    <td>
                    <div class="ui icon basic mini buttons">
                        <a :href="'comms.show.php?id='+comm.id" title="Open" class="ui button"><i class="folder open outline icon"></i></a>
                        <!-- <button onclick="updateFunc('<?php echo $controlNumber;?>')" title="Quick Edit" class="ui button"><i class="edit outline icon"></i></button> -->
                        <button onclick="deleteFunc('<?php echo $controlNumber;?>')" title="Delete" class="ui button"><i class="trash alternate outline icon"></i></button>
                    </div>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
<script>
    $(".dropdown").dropdown();
    var app = new Vue({
        el: "#app",
        data: {
            year: 0,
            department_id: 0,
            comms: {}
        },
        methods: {
            getData(){
                $.getJSON("comms.ajax.php", {getData:true},
                    (data, textStatus, jqXHR)=>{
                        this.comms = data;
                    });
            }
        },
        watch: {
            department_id: function(val,oldVal){
                 console.log(val);
             }
        },
        mounted(){
            this.getData()
            console.log(this.comms);
            
        }
    })
</script>
<style>
    .valigntop{
        vertical-align: top !important;
    }
    .nowrap {
        white-space: nowrap !important;
    }
</style>


<?php require_once "footer.php"; ?>