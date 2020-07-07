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
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
  
      <div class="ui icon fluid input" style="width: 300px;">
        <input id="data_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div>
    </div>
    </div>
  </div>

<table class="ui selectable very compact small striped celled table">
  <thead>
    <tr>
      <th>Item No.</th>
      <th>Position</th>
      <th>Department</th>
      <th class="center aligned">Vacated By</th>
      <th class="center aligned">Options</th>
    </tr>
  </thead>
  <tbody>
    <template v-for="(plantilla,i) in plantillas">
      <tr>
        <td>{{plantilla.item_no}}</td>
        <td>{{plantilla.position}} <i style="color: grey;">{{formatFunc(plantilla.functional)}}</i></td>
        <td>{{plantilla.department}}</td>
        <td>{{plantilla.vacated_by}}</td>
        <td class="center aligned">
              <div :id="'publishbtn'+plantilla.id" class="ui animated green mini button" v-on:click.self="publish(event)">
                <div class="visible content"><i class="paper plane outline icon"></i></div>
                <div class="hidden content">
                  <!-- Publish -->
                  {{plantilla.item_no}}
                </div>
              </div>
        </td>
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
