<?php 
	$title = "Publication"; 
	require_once "header.php";
?>
<div id="app" class="ui container fluid" style="margin: 5px;">

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="bullhorn icon"></i> Publication</h3>
    </div>
    <div class="right item">
    <div class="ui right input">
      <a href="publication_report_gen.php" target="_blank" class="ui mini green button" style="margin-right: 5px;" title="Generate File for Publication"><i class="icon file excel outline"></i>Generate File</a>/
    </div>
    </div>
  </div>
  <div class="ui fluid container" style="min-height: 6190px;">
    <div></div>
<style>
  th {
    padding: 2px !important;
  }
</style>
<table class="ui celled very small compact structured table ">
  <thead style="text-align:center;">
    <tr>
      <th rowspan="2">No.</th>
      <th rowspan="2">Position Title</th>
      <th rowspan="2">Plantilla Item No.</th>
      <th rowspan="2" style="width: 10px;">Salary/ Job/ Pay Grade</th>
      <th rowspan="2">Monthly Salary</th>
      <th colspan="5">Qualification Standards</th>
      <th rowspan="2">Place of Assignment</th>
    </tr>
    <tr>
      <th>Education</th>
      <th>Training</th>
      <th>Experience</th>
      <th>Eligibilty</th>
      <th>Compentency (if applicable)</th>
    </tr>
  </thead>
  <tbody>
<template>

<tr v-for="(post,i) in data">
  <td>{{i+1}}</td>
  <td>{{post.position_title}}</td>
  <td>{{post.item_no}}</td>
  <td>{{post.sg}}</td>
  <td>{{post.monthly_salary}}</td>
  <td>{{post.education}}</td>
  <td>{{post.training}}</td>
  <td>{{post.experience}}</td>
  <td>{{post.eligibility}}</td>
  <td>{{post.competency}}</td>
  <td>{{post.department }}</td>
</tr>    
  
</template>
  </tbody>
</table>

  </div>
</div>

<script>
new Vue({
  el: "#app",
  data: {
    data: []
  },
  methods: {
    getData(){
      $.ajax({
        type: "post",
        url: "publication_proc.php",
        data: {
          getData: true
        },
        dataType: "json",
        success: (response)=>{
            this.data = response;
        },
        async: false
      });
    }
  },
  mounted(){
    this.getData()
    console.log(this.data);
    
  }
})
</script>

<?php 
	require_once "footer.php";
?>
