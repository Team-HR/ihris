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
    <div class="right item">
      <a href="javascript:void(0)" onclick="print()" class="ui small green button"><i class="ui icon print"></i> Print</a>
    </div>
  </div>
</div>

<div class="ui container" style="background-color: white; width: 1300px;">
<h1 class="ui header center aligned">Competency Report</h1>
  <div class="ui segment" id="app">
    <template v-for="cat in data">
      <h1 class="ui blue header block">{{combineCat(cat.filters)}}</h1>
      <!-- chart here -->
      <chart-component v-if="cat.male.employees != '' && cat.female.employees != ''" :chart-data="combineMaleAndFemaleData(cat.male.average,cat.female.average)"></chart-component>
      <div class="ui grid">
        <div class="eight wide column">
          <div class="ui segment">
            <h5 class="ui header"><i class="ui icon mars"></i> MALE</h5>
            <hr class="ui divider">
            <ol class="ui ol" :class="{ divideColumn: cat.male.employees.length > 10?true:false}">
              <li v-for="employee in cat.male.employees">{{employee.toUpperCase()}}</li>
            </ol>
            <h1 class="ui header grey center aligned" v-if="cat.male.employees == ''">--None--</h1>
          </div>
        </div>
        <div class="eight wide column">
          <div class="ui segment">
            <h5 class="ui header"><i class="ui icon venus"></i> FEMALE</h5>
            <hr class="ui divider">
            <ol class="ui ol" :class="{ divideColumn: cat.female.employees.length > 10?true:false}">
              <li v-for="employee in cat.female.employees">{{employee.toUpperCase()}}</li>
            </ol>
            <h1 class="ui header grey center aligned" v-if="cat.male.employees == ''">--None--</h1>
          </div>
        </div>
      </div>
    </template>


  </div>
</div>

<script>
  var app = new Vue({
    el: '#app',
    data: {
      data: [],
    },
    methods: {
      combineCat(arr) {
        return arr[0] + " :: " + arr[1]
      },
      fetchData() {

        $.ajax({
          type: "post",
          url: "personnelCompetenciesReport_proc.php",
          data: {
            fetchData: true
          },
          dataType: "json",
          success: (response)=>{
            this.data = response
          },
          async:false
        });
              

      },
      combineMaleAndFemaleData(arr1,arr2){
        return {
          male: arr1,
          female: arr2
        }
      }

    },
    mounted() {
      console.log("mounted!");
      this.fetchData()
      $(".myChart").each(function (index, element) {
        // element == this
        console.log(element);
      });
    }

  });


  Vue.component('chart-component', {
    props:{
      chartData:Object
    },
    mounted() {
      console.log(this.chartData);
      console.log(this.$el);

var myChart = new Chart(this.$el.getContext('2d'), {
    type: 'bar',
    data: {
        labels: this.chartData.male.label,
        datasets: [
          {
            label: 'Male',
            data: this.chartData.male.average,
            backgroundColor: '#4075a975',
            borderColor:'#4075a9',
            borderWidth: 1
          },
          {
            label: 'Female',
            data: this.chartData.female.average,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor:'rgba(255, 99, 132, 1)',
            borderWidth: 1
          },
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

    },
    template: '<canvas height="100"></canvas>'
  })
</script>
<style>
  .divideColumn {
    -moz-column-count: 2;
    -moz-column-gap: 20px;
    -webkit-column-count: 2;
    -webkit-column-gap: 20px;
    column-count: 2;
    column-gap: 20px;
  }
</style>

<?php require_once "footer.php"; ?>