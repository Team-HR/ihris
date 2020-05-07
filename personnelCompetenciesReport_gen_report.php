<?php $title = "Generate Competency Report";
require_once "header.php";
require_once "_connect.db.php"; ?>
<script src="js/competencies_array.js"></script>


<div class="ui container" style="width: 1300px; margin-bottom: 20px;">
  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="icon chart line"></i>Generate Competency Report</h3>
    </div>
    <div class="right item" style="">
      <a href="javascript:void(0)" class="ui small green button"><i class="ui icon print"></i> Print</a>
    </div>
  </div>
</div>

<div class="ui container" style="background-color: white; width: 1300px;">
  <div class="ui segment" id="app">
    <template v-for="cat in data">
        <h1>{{combineCat(cat.filters)}}</h1>
        <div class="ui grid">
            <div class="four wide column">
                <h5>Male</h5>
                <!-- <p>{{cat.male.average}}</p> -->
                {{Math.round((cat.male.employees.length)/2)}}
                <ol class="ui ol">
                    <li v-for="employee in cat.male.employees">{{employee}}</li>
                </ol>
            </div>
            <div class="four wide column">
                <h5>Female</h5>
                <!-- <p>{{cat.female.average}}</p> -->
                {{cat.female.employees.length}}
                <ol class="ui ol">
                    <li v-for="employee in cat.female.employees">{{employee}}</li>
                </ol>
            </div>
        </div>
    </template>
    

  </div>
</div>

<script>
    var app = new Vue({
        el:'#app',
        data: {
            data: []
        },
        calculated: {
        },
        methods:{
            combineCat(arr){
                return arr[0]+" :: "+arr[1]
            },
            fetchData(){
                $.post("personnelCompetenciesReport_proc.php", {fetchData:true},
                    (data, textStatus, jqXHR)=>{
                        this.data = data;
                        console.log(this.data)
                    },
                    "json"
                )
            }
        },
        created: function (){
            this.fetchData()
        }
        
    });
</script>

<?php require_once "footer.php"; ?>