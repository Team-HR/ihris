<?php $title = "Training Needs Assessment (TNA)"; require_once "header.php";?>

<script type="text/javascript">
var content = [],
    manager_arr = [],
    staff_arr = [],
    all_arr = [],
    tools_arr = [],
    manager_arr_edit = [],
    staff_arr_edit = [],
    all_arr_edit = [],
    tools_arr_edit = [];
  
  $(document).ready(function() {
    $("#addDeptsList").dropdown({showOnFocus: false});
    $("#findDeptDrop").dropdown({
      onChange: function (value,text){ 
        // alert(value);
        if (value != "all") {
          var depts = $(".depts");
          $.each(depts, function(index, val) {
             $(this).hide();
          });
          $("#"+value).show();
        } else {
          $(load);
        }
      }
    });
    $("#tabs .item").tab();

    $(load);

  });

  function load(){
    $("#load_container").load('tna_proc.php',{
      load: true,
    } ,
      function(){
      $(populate_findDeptDrop);
      $(getTrainings);
    });
    
  }

  function getTrainings(){
    $.post('tna_proc.php', {
        getTrainings: true}, 
      function(data, textStatus, xhr) {
      content = jQuery.parseJSON(data);
      $('.getTrainings').search({
        source: content
      });
    });
  }

  function getDepartments(){
    $.post('tna_proc.php', {
      getDepartments: true}, 
    function(data, textStatus, xhr) {
        
    });
  }

  function list_add_manager(){
      var ol_id = $("#ol_add_manager"),
      input_id = $("#input_add_manager"),
      array = manager_arr,
      i = "manager";
      list_add(ol_id,input_id,array,i);
  }

  function list_add_staff(){
      var ol_id = $("#ol_add_staff"),
      input_id = $("#input_add_staff"),
      array = staff_arr,
      i = "staff";
      list_add(ol_id,input_id,array,i);
  }

  function list_add_all(){
      var ol_id = $("#ol_add_all"),
      input_id = $("#input_add_all"),
      array = all_arr,
      i = "all";
      list_add(ol_id,input_id,array,i);
  }

  function list_add_tools(){
      var ol_id = $("#ol_add_tools"),
      input_id = $("#input_add_tools"),
      array = tools_arr,
      i = "tools";
      list_add(ol_id,input_id,array,i);
  }

  function list_add(ol_id, input_id, array,i){
    ol_id.html("");
    var input = input_id.val();
    if ($.inArray(input, array) == -1 && input.trim()) {
      array.push(input);
    }

    if (i == "manager") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_manager(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "staff") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_staff(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "all") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_all(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "tools") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_tools(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    }

    input_id.val("");
  }

  function list_remove_manager(index){
    $("#ol_add_manager").html("");
    manager_arr.splice(index,1);
    $.each(manager_arr, function(index, val) {
      $("#ol_add_manager").append("<li><i class='icon times' onclick='list_remove_manager(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_staff(index){
    $("#ol_add_staff").html("");
    staff_arr.splice(index,1);
    $.each(staff_arr, function(index, val) {
      $("#ol_add_staff").append("<li><i class='icon times' onclick='list_remove_staff(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_all(index){
    $("#ol_add_all").html("");
    all_arr.splice(index,1);
    $.each(all_arr, function(index, val) {
      $("#ol_add_all").append("<li><i class='icon times' onclick='list_remove_all(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_tools(index){
    $("#ol_add_tools").html("");
    tools_arr.splice(index,1);
    $.each(tools_arr, function(index, val) {
      $("#ol_add_tools").append("<li><i class='icon times' onclick='list_remove_tools(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function addNew(){
    $(getTrainings);
    $("#modal_new").modal({
      closable: false,
      onDeny: function(){
        $(clear);
      },
      onApprove: function(){
        $.post('tna_proc.php', {
          addNew: true,
          department_id: $("#addDeptsList").dropdown("get value"),
          manager_arr: manager_arr,
          staff_arr: staff_arr,
          all_arr: all_arr,
          tools_arr: tools_arr,
        }, function(data, textStatus, xhr) {
            $(clear);
            $(load);
        });
      },
    }).modal("show");
  }

  function edit(tna_id){
    $("#ol_edit_manager").html("");
    $("#ol_edit_staff").html("");
    $("#ol_edit_all").html("");
    $("#ol_edit_tools").html("");

    $.post('tna_proc.php', {
      getEditValues: true,
      tna_id: tna_id,
    }, function(data, textStatus, xhr) {
      var array = jQuery.parseJSON(data);
      $("#editDeptsList").dropdown({
        showOnFocus: false
      }).dropdown("set selected", array.department_id);
      
      $.each(array.manager_arr, function(index, val) {
        $("#ol_edit_manager").append("<li><i class='icon times' onclick='list_remove_manager_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
        manager_arr_edit.push(val);
      });

      $.each(array.staff_arr, function(index, val) {
        $("#ol_edit_staff").append("<li><i class='icon times' onclick='list_remove_staff_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
        staff_arr_edit.push(val);
      });

      $.each(array.all_arr, function(index, val) {
        $("#ol_edit_all").append("<li><i class='icon times' onclick='list_remove_all_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
        all_arr_edit.push(val);
      });

      $.each(array.tools, function(index, val) {
        $("#ol_edit_tools").append("<li><i class='icon times' onclick='list_remove_tools_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
        tools_arr_edit.push(val);
      });

    });

   $(getTrainings);

    $("#modal_edit").modal({
      closable: false,
      onDeny: function (){
          $(clear);        
      },
      onApprove: function(){
        $.post('tna_proc.php', {
          edit: true,
          tna_id: tna_id,
          department_id: $("#editDeptsList").dropdown("get value"),
          manager_arr_edit: manager_arr_edit,
          staff_arr_edit: staff_arr_edit,
          all_arr_edit: all_arr_edit,
          tools_arr_edit: tools_arr_edit,
        }, function(data, textStatus, xhr) {
          $(clear);
          $(load);
        });
      },
    }).modal("show"); 
  }


  function list_remove_manager_edit(index){
    $("#ol_edit_manager").html("");
    manager_arr_edit.splice(index,1);
    $.each(manager_arr_edit, function(index, val) {
      $("#ol_edit_manager").append("<li><i class='icon times' onclick='list_remove_manager_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_staff_edit(index){
    $("#ol_edit_staff").html("");
    staff_arr_edit.splice(index,1);
    $.each(staff_arr_edit, function(index, val) {
      $("#ol_edit_staff").append("<li><i class='icon times' onclick='list_remove_staff_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_all_edit(index){
    $("#ol_edit_all").html("");
    all_arr_edit.splice(index,1);
    $.each(all_arr_edit, function(index, val) {
      $("#ol_edit_all").append("<li><i class='icon times' onclick='list_remove_all_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_remove_tools_edit(index){
    $("#ol_edit_tools").html("");
    tools_arr_edit.splice(index,1);
    $.each(tools_arr_edit, function(index, val) {
      $("#ol_edit_tools").append("<li><i class='icon times' onclick='list_remove_tools_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
    });
  }

  function list_add_manager_edit(){
      var ol_id = $("#ol_edit_manager"),
      input_id = $("#input_edit_manager"),
      array = manager_arr_edit,
      i = "manager";
      list_add_edit(ol_id,input_id,array,i);
  }

  function list_add_staff_edit(){
      var ol_id = $("#ol_edit_staff"),
      input_id = $("#input_edit_staff"),
      array = staff_arr_edit,
      i = "staff";
      list_add_edit(ol_id,input_id,array,i);
  }

  function list_add_all_edit(){
      var ol_id = $("#ol_edit_all"),
      input_id = $("#input_edit_all"),
      array = all_arr_edit,
      i = "all";
      list_add_edit(ol_id,input_id,array,i);
  }

  function list_add_tools_edit(){
      var ol_id = $("#ol_edit_tools"),
      input_id = $("#input_edit_tools"),
      array = tools_arr_edit,
      i = "tools";
      list_add_edit(ol_id,input_id,array,i);
  }

  function list_add_edit(ol_id, input_id, array,i){
    ol_id.html("");
    var input = input_id.val();
    if ($.inArray(input, array) == -1 && input.trim()) {
      array.push(input);
    }

    if (i == "manager") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_manager_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "staff") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_staff_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "all") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_all_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    } else if (i == "tools") {
      $.each(array, function(index, val) {
        ol_id.append("<li><i class='icon times' onclick='list_remove_tools_edit(\""+index+"\")' style='cursor: pointer;'></i>"+val+"</li>");
      });
    }

    input_id.val("");
  }


  function clear(){
    manager_arr = [];
    staff_arr = [];
    all_arr = [];
    tools_arr = [];
    manager_arr_edit = [];
    staff_arr_edit = [];
    all_arr_edit = [];
    tools_arr_edit = [];
  }


  function populate_findDeptDrop (){
    $.post('tna_proc.php', {
      populate_findDeptDrop: true},
      function(data, textStatus, xhr) {
        $("#findDeptDrop").html(data);
    });
  }

  function search_by_training(){
    var keyword = $("#search_by_training_input").val();
    // alert(keyword);
    // search_by_training_result
    $.post('tna_proc.php', {
      search_by_training: true,
      keyword: keyword
    }, function(data, textStatus, xhr) {
      /*optional stuff to do after success */
      $("#search_by_training_result").html(data);
      $('.accordion').accordion();
    });



  }

</script>

<?php
  require_once "message_pop.php";
?>

<div class="ui container">

  <div class="ui borderless blue inverted mini menu noprint">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon mini button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
     <h3><i class="icon compass outline"></i> L&D Training Needs Assessment</h3>
   </div>
   <div class="right item">
    <div class="ui right input">
    <button class="ui icon green mini button" onclick="addNew()" style="margin-right: 5px;"><i class="icon plus"></i>Add</button>
    </div>
   </div>
</div>


<div class="ui top attached tabular menu" id="tabs" style="background-color: white;">
  <a class="item active" data-tab="tna">TNA</a>
  <a class="item" data-tab="targetPart">Target Participants</a>
</div>
<div class="ui bottom attached tab segment active" data-tab="tna">

  <div class="ui secondary small menu noprint">
   <div class="right item">
    <div class="ui right input">

    <div style="padding: 0px; margin: 0px; margin-right: 5px; width: 500px;">
        <select id="findDeptDrop" class="ui fluid dropdown selection"> 
        </select>
    </div>

    </div>
   </div>
</div>

  <div class="ui container" id="load_container"></div>
</div>
<div class="ui bottom attached tab segment" data-tab="targetPart">
  <!-- Target Participants... -->
<div class="ui form">
    <div class="eight wide field">
  <!--     <label>Search by Training:</label>
      <input type="text" id="searchBytraining_input" placeholder="Training Title..."> -->
      <label>Search by Training:</label>
      <div class="ui search" id="search_by_training">
        <div class="ui icon input">
          <input id="search_by_training_input" class="prompt" type="text" placeholder="Search training...">
          <i class="search icon"></i>
        </div>
        <div class="results"></div>
      </div>
    </div>
    <button class="ui mini button blue" onclick="search_by_training()">Search</button>
</div>

  <div id="search_by_training_result" class="ui basic segment fluid" style="min-height: 300px;">
    <h1 style="color: lightgrey; text-align: center; margin-top: 100px;">...SEARCH TRAINING...</h1>
  </div>

</div>
<!-- menu end -->

<!-- add modal start -->
<div class="ui large modal" id="modal_new">
  <div class="header">Add New</div>
  <div class="content">
    <div class="ui form">
      <div class="eight wide field">
        <label>Department:</label>

<div id="addDeptsList" class="ui selection dropdown">
  <input type="hidden" id="department_id">
  <i class="dropdown icon"></i>
  <div class="default text">Select Department</div>
  <div class="menu">
   <?php
   require_once "_connect.db.php";
     $sql = "SELECT * FROM `department` WHERE `department_id` NOT IN (SELECT `department_id` FROM `tna`) ORDER BY `department` ASC";
     $result = $mysqli->query($sql);
     while ($row = $result->fetch_assoc()) {
       $department_id = $row["department_id"];
       $department = $row["department"];
       ?>
       <div class="item" data-value="<?php echo $department_id;?>"><?php echo $department;?></div>
     <?php
    }  
   ?>
  </div>
</div>
      </div>
      <div class="fields">
        <div class="four wide field">
          <!-- <label>Manager:</label> -->
          <h5 class="ui header center aligned">Manager</h5>

<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_add_manager">
    <button class="ui icon button" onclick="list_add_manager()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
          <ol class="ui list" id="ol_add_manager"></ol>

        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">Staff</h5>
<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_add_staff">
    <button class="ui icon button" onclick="list_add_staff()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_add_staff"></ol>
        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">All</h5>
<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_add_all">
    <button class="ui icon button" onclick="list_add_all()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_add_all"></ol>
        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">Tools/Resources</h5>
<div class="ui search">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Add Tools/Resources" id="input_add_tools">
    <button class="ui icon button" onclick="list_add_tools()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_add_tools"></ol> 
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui approve tiny basic button">Save</div>
    <div class="ui cancel tiny basic button">Cancel</div>
  </div>
</div>
<!-- add modal end -->

<!-- edit modal start -->
<div class="ui large modal" id="modal_edit">
  <div class="header">Edit</div>
  <div class="content">
    <div class="ui form">
      <div class="eight wide field">
<label>Department:</label>
<div id="editDeptsList" class="ui selection dropdown" autofocus="false">
  <input type="hidden" id="department_id">
  <i class="dropdown icon"></i>
  <div class="default text">Select Department</div>
  <div class="menu">
   <?php
   require_once "_connect.db.php";
     $sql = "SELECT * FROM `department` ORDER BY `department` ASC";
     $result = $mysqli->query($sql);
     while ($row = $result->fetch_assoc()) {
       $department_id = $row["department_id"];
       $department = $row["department"];
       ?>
       <div class="item" data-value="<?php echo $department_id;?>"><?php echo $department;?></div>

     <?php
    }  
   ?>
  </div>
</div>
      </div>
      <div class="fields">
        <div class="four wide field">
          <h5 class="ui header center aligned">Manager</h5>

<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_edit_manager">
    <button class="ui icon button" onclick="list_add_manager_edit()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
          <ol class="ui list" id="ol_edit_manager"></ol>

        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">Staff</h5>
<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_edit_staff">
    <button class="ui icon button" onclick="list_add_staff_edit()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_edit_staff"></ol>
        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">All</h5>
<div class="ui search getTrainings">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Search/Add Training" id="input_edit_all">
    <button class="ui icon button" onclick="list_add_all_edit()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_edit_all"></ol>
        </div>
        <div class="four wide field">
          <h5 class="ui header center aligned">Tools/Resources</h5>
<div class="ui search">
  <div class="ui action input">
    <input class="prompt" type="text" placeholder="Add Tools/Resources" id="input_edit_tools">
    <button class="ui icon button" onclick="list_add_tools_edit()"><i class="plus icon"></i></button>
  </div>
  <div class="results"></div>
</div>
        <ol class="ui list" id="ol_edit_tools"></ol> 
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui approve tiny basic button">Save</div>
    <div class="ui cancel tiny basic button">Cancel</div>
  </div>
</div>
<!-- edit modal end -->

</div>
<?php require_once "footer.php";?>
