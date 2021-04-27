<?php $title = "L&D Plan LGU Sponsored";
require_once "header.php";
require_once "_connect.db.php";
// get year 
$ldplan_id = $_GET["ldplan_id"];

$sql = "SELECT `year` FROM `ldplan` WHERE `ldplan_id` = '$ldplan_id'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$year = $row["year"];

?>

<script type="text/javascript">
  $(document).ready(function() {
    // $(addNew);
    // $(load);

    $("#table_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

  });

  // function load() {
  //   $("#tableBody").load('ldplanlgusponsored_proc.php', {
  //       load: true,
  //       ldplan_id: <?php echo $ldplan_id; ?>
  //     },
  //     function() {
  //       /* Stuff to do after the page is loaded */
  //     });

  //   $.post('ldplanlgusponsored_proc.php', {
  //       getTrainings: true
  //     },
  //     function(data, textStatus, xhr) {
  //       var content = jQuery.parseJSON(data);
  //       $('.getTrainings').search({
  //         source: content,
  //         searchOnFocus: false
  //       });
  //     });

  // }

  // function addNew() {
  //   $("#modal_new").modal({
  //     closable: false,
  //     onHidden: function() {
  //       $(clear);
  //     },
  //     onDeny: function() {
  //       $(clear);
  //     },
  //     onApprove: function() {
  //       $.post('ldplanlgusponsored_proc.php', {
  //         addNew: true,
  //         ldplan_id: <?php echo $ldplan_id; ?>,
  //         training: $("#title_add").val(),
  //         goal: $("#goal_add").val(),
  //         numHours: $("#hrs_add").val(),
  //         participants: $("#participants_add").val(),
  //         activities: $("#methods_add").val(),
  //         evaluation: $("#eval_add").val(),
  //         frequency: $("#freq_add").val(),
  //         budgetReq: $("#budget_add").val(),
  //         partner: $("#partner_add").val(),
  //       }, function(data, textStatus, xhr) {
  //         $(load);
  //         $(msg_added);
  //       });
  //     }
  //   }).modal("show");
  // }

  function editRow(ldplgusponsoredtrainings_id) {
    $.post('ldplanlgusponsored_proc.php', {
      getRowData: true,
      ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id
    }, function(data, textStatus, xhr) {
      var array = jQuery.parseJSON(data);
      $("#title_edit").val(array.training);
      $("#goal_edit").val(array.goal);
      $("#hrs_edit").val(array.numHours);
      $("#participants_edit").val(array.participants);
      $("#methods_edit").val(array.activities);
      $("#eval_edit").val(array.evaluation);
      $("#freq_edit").val(array.frequency);
      $("#budget_edit").val(array.budgetReq);
      $("#partner_edit").val(array.partner);

      $("#modal_edit").modal({
        onApprove: function() {
          $.post('ldplanlgusponsored_proc.php', {
            editRow: true,
            ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id,
            title_edit: $("#title_edit").val(),
            goal_edit: $("#goal_edit").val(),
            hrs_edit: $("#hrs_edit").val(),
            participants_edit: $("#participants_edit").val(),
            methods_edit: $("#methods_edit").val(),
            eval_edit: $("#eval_edit").val(),
            freq_edit: $("#freq_edit").val(),
            budget_edit: $("#budget_edit").val(),
            partner_edit: $("#partner_edit").val(),
          }, function(data, textStatus, xhr) {
            $(load);
            $(msg_saved);
          });
        }
      }).modal("show");
    });
  }

  // function deleteRow(ldplgusponsoredtrainings_id) {
  //   $("#modal_delete").modal({
  //     onApprove: function() {
  //       $.post('ldplanlgusponsored_proc.php', {
  //         deleteRow: true,
  //         ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id
  //       }, function(data, textStatus, xhr) {
  //         $(load);
  //         $(msg_deleted);
  //       });
  //     }
  //   }).modal("show");
  // }

  function clear() {
    $("#title_add").val("");
    $("#goal_add").val("");
    $("#hrs_add").val("");
    $("#participants_add").val("");
    $("#methods_add").val("");
    $("#eval_add").val("");
    $("#freq_add").val("");
    $("#budget_add").val("");
    $("#partner_add").val("");
  }
</script>

<?php
require_once "message_pop.php";
?>

<!-- vue app start -->
<div id="lnd-plan-vue">
  <template>
    <div class="ui container">
      <div class="ui borderless blue inverted mini menu noprint">
        <div class="left item" style="margin-right: 0px !important;">
          <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
            <i class="icon chevron left"></i> Back
          </button>
        </div>
        <div class="item">
          <h3><i class="icon compass outline"></i>L&D Plan LGU Sponsored Trainings <?php echo $year; ?></h3>
        </div>
        <div class="right item">
          <button class="ui icon green button" @click="editPlan(-1)"><i class="icon plus"></i>Add</button>
          <button onclick="print()" class="blue ui icon button" title="Back" style="margin-right: 5px;">
            <i class="icon print"></i> Print
          </button>
          <div class="ui icon fluid input" style="width: 300px;">
            <input id="table_search" type="text" placeholder="Search...">
            <i class="search icon"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="ui fluid container" style="padding: 20px;">
      <h4 align="center" class="printOnly">LEARNING & DEVELOPMENT PLAN FOR <?php echo $year; ?><br>LGU Sponsored Trainings</h4>


      <table class="ui very compact celled structured small selectable table">
        <thead>
          <tr style="text-align: center;">
            <th class="headers">No.</th>
            <th class="headers">Title of Training</th>
            <th class="headers">Training Goal/Objectives</th>
            <th class="headers">No. Hours</th>
            <th class="headers">Target Participants</th>
            <th class="headers"></th>
            <th class="headers">Learning Methods/Activities</th>
            <th class="headers">Evaluation/Evidence of Learning</th>
            <th class="headers">Frequency</th>
            <th class="headers">Budgetary Requirements</th>
            <th class="headers">Training Institution/Partner</th>
            <th class="headers">Venue</th>
            <th class="noprint headers"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" :key="index">
            <td>{{ index+1 }}</td>
            <td style="font-weight: bold;">{{item.training}}</td>
            <td>{{item.goal}}</td>
            <td style="text-align: center;">{{item.numHours}} hrs</td>
            <td>{{item.participants}}</td>
            <td class="center aligned">
              <!-- {{ item.targetParticipants.countDepartments }} -->
              <button class="ui mini block button" :class="isNotEmpty(item.targetParticipants)?'':'disabled'" @click="showParticipants(item.training,item.targetParticipants)">Show Participants</button>
            </td>
            <td>{{item.activities}}</td>
            <td>{{item.evaluation}}</td>
            <td>{{item.frequency}}</td>
            <td>
              <div class="" v-if="item.budget">
                <div class="ui center aligned">
                  <div class="ui mini header block">Php. {{thousands_separators(item.budget.allocated)}}</div>
                </div>
                <div class="ui center aligned">
                  <cite v-if="item.frequency=='Semi-Annually'">
                    (x2 = {{thousands_separators(item.budget.allocated * 2)}})
                  </cite>
                </div>
                <table class="ui structured very compact celled table" v-if="item.budget.fors">
                  <tr v-for="(para, p) in item.budget.fors" :key="p">
                    <td>{{p+1}}</td>
                    <td>{{para.for}}</td>
                    <td>{{thousands_separators(para.amount)}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right;">Total:</td>
                    <td>{{thousands_separators(getTotal(item.budget.fors))}}</td>
                  </tr>
                </table>
              </div>
              <button class="ui mini fluid button noprint" @click="editBudget(item)"><i class="ui icon edit"></i>Edit Budget</button>
            </td>
            <td>{{item.partner}}</td>
            <td>{{item.venue}}</td>
            <td class="right aligned noprint">
              <div class="ui mini basic icon buttons">
                <button class="ui button" title="Edit" @click="editPlan(index)"><i class="edit outline icon"></i></button>
                <button class="ui button" title="Delete" @click="deleteRow(item.ldplgusponsoredtrainings_id)"><i class="trash alternate outline icon"></i></button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>




      <div class="ui first coupled small modal" style="max-width: 500px ;">
        <div class="header">
          Edit Budget
        </div>
        <div class="content">
          <!-- budget editor start -->
          <div class="ui segment">
            <label>Allocated Amount:</label>
            <div class="ui input">
              <input type="number" v-model="budget.allocated">
            </div>
            <br>
            <table>
              <thead>
                <tr>
                  <th colspan="4">Breadkdown:</th>
                </tr>
              </thead>
              <tr v-for="(alloc, af) in budget.fors" :key="af">
                <td width="10">{{af+1}}.)</td>
                <td>

                  <div class="ui input">
                    <input type="text" v-model="alloc.for">
                  </div>
                </td>
                <td>
                  <div class="ui input">
                    <input type="number" v-model="alloc.amount" @blur="sortBudgetFors">
                  </div>
                </td>
                <td><i class="ui link icon times" @click="trashFor(af)"></i></td>
              </tr>
              <tr>
              <tr>
                <td colspan="4">
                  <button class="ui mini fluid button" @click="addFor"><i class="ui icon add"></i> Add</button>
                </td>
              </tr>
              </tr>
            </table>
            <!-- <label>Total: </label> {{thousands_separators(totalBudget)}} -->
            <br>
            <!-- <label>Change: </label> {{thousands_separators(changeBudget)}} -->
            <!-- <br> -->
          </div>
        </div>
        <div class="actions">
          <button class="ui button deny" @click="saveBudget">Save & Exit</button>
          <button class="ui button deny">Cancel</button>
        </div>
      </div>

















    </div>


    <!-- addnew modal start -->
    <div class="ui modal" id="editModal">
      <div class="header" id="editModalTitle"></div>
      <div class="content">
        <div class="ui form" @submit.prevent="">
          <div class="fields">
            <div class="eight wide field">
              <label>Title of Training:</label>
              <!-- <textarea id="title_add" rows="3" placeholder="Title of training..."></textarea> -->
              <div class="ui search getTrainings">
                <div class="ui icon input">
                  <input v-model="plan.training" class="prompt" type="text" placeholder="Search/Add Training...">
                </div>
                <div class="results"></div>
              </div>
            </div>
            <div class="eight wide field">
              <label>Training Goal/Objective:</label>
              <textarea v-model="plan.goal" rows="3" placeholder="Goal/Objective of training..."></textarea>
            </div>
          </div>
          <div class="fields">
            <div class="four wide field">
              <label>Total Number of Training Hours:</label>
              <input v-model="plan.numHours" type="number" placeholder="Hrs">
            </div>
            <div class="four wide field"></div>
            <div class="eight wide field">
              <label>Target Participants:</label>
              <textarea v-model="plan.participants" rows="3" type="text" placeholder="Participants..."></textarea>
            </div>
          </div>
          <div class="fields">
            <div class="eight wide field">
              <label>Learning Methods/Activities:</label>
              <textarea v-model="plan.activities" rows="3" placeholder="Learning Methods/Activities..."></textarea>
            </div>
            <div class="eight wide field">
              <label>Evaluation/Evidence of Learning:</label>
              <textarea v-model="plan.evaluation" rows="3" placeholder="Evaluation/Evidence of Learning..."></textarea>
            </div>
          </div>
          <div class="fields">
            <div class="four wide field">
              <label>Frequency:</label>
              <textarea v-model="plan.frequency" rows="3" type="text" placeholder="Frequency..."></textarea>
            </div>

            <div class="four wide field">
              <label>Budgetary Requirements:</label>
              <!-- <textarea v-model="plan.budgetReq" rows="3" type="text" placeholder="Budgetary Requirements..."></textarea> -->


              <div class="" v-if="plan.budget">
                <div class="ui center aligned">
                  Php. {{thousands_separators(plan.budget.allocated)}}
                </div>
                <!-- <div class="ui center aligned">
                  <cite v-if="item.frequency=='Semi-Annually'">
                    (x2 = {{thousands_separators(item.budget.allocated * 2)}})
                  </cite>
                </div> -->
                <table class="ui structured very compact celled table" v-if="plan.budget.fors">
                  <tr v-for="(para, p) in plan.budget.fors" :key="p">
                    <td>{{p+1}}</td>
                    <td>{{para.for}}</td>
                    <td>{{thousands_separators(para.amount)}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: right;">Total:</td>
                    <td>{{thousands_separators(getTotal(plan.budget.fors))}}</td>
                  </tr>
                  <!-- <tr>
                    <td colspan="2" style="text-align: right;">Change:</td>
                    <td>{{thousands_separators(getChange(item.budget))}}</td>
                  </tr> -->
                </table>
              </div>

              <button class="ui fluid mini button" @click="editBudget(plan)">Edit Budget</button>
            </div>

            <div class="eight wide field">
              <label>Training Institution/Partner:</label>
              <textarea v-model="plan.partner" rows="3" type="text" placeholder="Training Institution/Partner..."></textarea>
            </div>
          </div>
          <div class="fields">
            <div class="eight wide field">
              <label>Venue:</label>
              <textarea v-model="plan.venue" rows="3" type="text" placeholder="Venue..."></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="actions">
        <div class="ui approve tiny basic button">Save</div>
        <div class="ui cancel tiny basic button">Cancel</div>
      </div>
    </div>
    <!-- addnew modal end -->

    <!-- delete modal start -->
    <div class="ui mini modal" id="modal_delete">
      <div class="header"></div>
      <div class="content">
        Are you sure you want to delete this entry?
      </div>
      <div class="actions">
        <div class="ui approve tiny basic button">Yes</div>
        <div class="ui cancel tiny basic button">No</div>
      </div>
    </div>
    <!-- delete modal end -->
    <!-- showParticipantsModal modal start -->
    <div class="ui small modal" id="showParticipantsModal">
      <div class="header">{{participants.training}}</div>
      <div class="content">
        <!-- {{participants}} -->

        <div class="ui accordion" id="showParticipantsAccordion">
          <div v-for="(item, i) in participants.participants" :key="i">
            <div class="title">
              <i class="dropdown icon"></i>
              {{item.department}}
            </div>
            <div class="content">
              <!-- <p class="transition hidden">A dog is a type of domesticated animal. Known for its loyalty and faithfulness, it can be found as a welcome guest in many households across the world.</p> -->

              <table class="ui very compact celled structured table">
                <tr>
                  <th>Managers</th>
                  <th>Staffs</th>
                  <th>All</th>
                </tr>
                <tr>
                  <td>
                    <ol>
                      <li v-for="(mgr, m) in item.managers" :key="m">{{mgr}}</li>
                    </ol>
                  </td>
                  <td>
                    <ol>
                      <li v-for="(staff, s) in item.staffs" :key="s">{{staff}}</li>
                    </ol>
                  </td>
                  <td>
                    <ol>
                      <li v-for="(al, a) in item.all" :key="a">{{al}}</li>
                    </ol>
                  </td>
                </tr>
              </table>


            </div>
          </div>
        </div>


      </div>
      <!-- <div class="actions">
        <div class="ui approve tiny basic button">Yes</div>
        <div class="ui cancel tiny basic button">No</div>
      </div> -->
    </div>
    <!-- showParticipantsModal modal end -->

  </template>
</div>
<!-- vue app end -->

<script src="./ldplanlgusponsored.js"></script>
<!-- delete modal end -->
<?php require_once "footer.php"; ?>