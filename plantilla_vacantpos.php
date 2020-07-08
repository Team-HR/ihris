<?php 
  $title = "Vacant Positions"; 
  require_once "header.php";
?>
<div id="app" class="ui segment">
  <div class="ui fluid container">
  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="briefcase icon"></i>Vacant Positions</h3>
    </div>
    <div class="right item">
      <div class="ui right input">
        <a href="publication_report_gen.php" target="_blank" class="ui mini green button" style="margin-right: 5px;" title="Generate File for Publication"><i class="icon file excel outline"></i>Generate File</a>
      </div>
    <div class="ui right input">
  
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="data_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
    </div>
  </div>

<table class="ui selectable very compact mini striped celled table">
  <thead>
    <tr>
      <th>#</th>
      <th class="center aligned" width="150">Options</th>
      <th width="80" class="center aligned">Item No.</th>
      <th>Position</th>
      <th>Department</th>
      <th class="center aligned">Vacated By</th>
    </tr>
  </thead>
  <tbody>
    <template v-for="(plantilla,key,i) in plantillas">
      <tr :key="plantilla.id" :class="{green: plantilla.isPublished?true:false}">
        <td>{{i+1}}</td>
        <td class="center aligned">
          <button :style="{display: plantilla.isPublished?'none':''}" class="ui mini fluid primary button" @click="publish(plantilla.id)"><i class="paper plane outline icon"></i> Publish</button>
          <div :style="{display: !plantilla.isPublished?'none':''}" class="ui animated mini green fluid button" @click="restore(plantilla.id)">
            <div class="visible content">
              <i class="check icon"></i> Published
            </div>
            <div class="hidden content">
              <i class="undo alternative icon"></i> Restore
            </div>
          </div>
        </td>
        <td class="center aligned">{{plantilla.item_no}}</td>
        <td>{{plantilla.position}} <i style="color: grey;">{{formatFunc(plantilla.functional)}}</i></td>
        <td>{{plantilla.department}}</td>
        <td>{{plantilla.vacated_by}}</td>
      </tr>
    </template>
  </tbody>
</table>
    </div>
  </div>
<script src="publication/vacant_positions.js"></script>
<?php 
  require_once "footer.php";
?>
