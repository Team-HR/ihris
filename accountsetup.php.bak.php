<?php $title="Accounts Setup"; include 'header.php'; ?>

<script type="text/javascript">
  $(document).ready(function() {

    $(load);
    $(".ui.dropdown").dropdown({showOnFocus: false});    
  });

  function load(){
    $(loadConfirmed);
    $(loadRequests);
    $(loadDenied);
  }

  function loadRequests(){
    $("#user_table_request").load('accountsetup_proc.php', {
      loadRequests: true
    }, function(data, textStatus, xhr) {

    });
  }  

  function loadConfirmed(){
    $("#user_table").load('accountsetup_proc.php', {
      loadConfirmed: true
    }, function(data, textStatus, xhr) {
      /*optional stuff to do after success */
    });
  }

  function loadDenied(){
    $("#user_table_denied").load('accountsetup_proc.php', {
      loadDenied: true
    }, function(data, textStatus, xhr) {
      /*optional stuff to do after success */
    });
  }



  function reqsOption (id){
    // alert(id);
    $("#modal_reqsOption").modal({
      closable: false,
    }).modal("show");

    $("#reqsForm").form({
      on: 'submit',
      onSuccess: function(e){
        e.preventDefault();
        $("#modal_reqsOption").modal("hide");
        $(load);
        // alert($("#selType").dropdown("get value"));
        $.post('accountsetup_proc.php', {
          confirmed: true,
          id: id,
          type: $("#selType").dropdown("get value"),
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
        });
      },
      fields: {
       selType: {
              identifier  : 'selType',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please select the account type.'
                }
              ]
            },

        }
    });


    $("#reqsDeny").click(function(event) {
      // alert("Denied!");
        $.post('accountsetup_proc.php', {
          denied: true,
          id: id,
          // type: $("#selType").dropdown("get value"),
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
           $("#modal_reqsOption").modal("hide");
           $(load);
        });
    });

  }

  function addNew(){

      $("#regModal").modal({closable:false,allowMultiple: true}).modal("show");
      $('#registerForm').form({
        on: 'submit',
        // inline: true,
        // transition: 'drop',
        onSuccess: function (event, fields){
          event.preventDefault();
        var usrdata = [
          $("input[name='firstName']").val(),
          $("input[name='middleName']").val(),
          $("input[name='lastName']").val(),
          $("input[name='extName']").val(),
          $("input[name='userName']").val(),
          $("input[name='password']").val()
        ];

          
          $.post('login_proc.php', {
            register: true,
            usrdata: usrdata
          }, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
            if (data === "0") {
              $("#regModal").modal("hide");
              $(load);
              // $("#registerSuccess").modal({
              //   allowMultiple: false,
              //   onDeny: function(){
              //     location.reload();
              //   }
              // }).modal("show");
          $("input[name='firstName']").val("");
          $("input[name='middleName']").val("");
          $("input[name='lastName']").val("");
          $("input[name='extName']").val("");
          $("input[name='userName']").val("");
          $("input[name='password']").val("");
          $("input[name='password_verify']").val("");
              console.log(data);
            } else if (data === "1") {
              console.log(data);
              $("#registerForm").form("add errors",["Username is already taken! Please re-enter a different one."]);
              $("#registerForm").form("add prompt","userName",["Username is already taken! Please re-enter a different one."]);
            }
            // alert(data);
          });

        },
        fields: {
          firstName: {
            identifier  : 'firstName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your firstname.'
            }
            ]
          },
          lastName: {
            identifier  : 'lastName',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your lastname.'
            }
            ]
          },
          regex: {
                  identifier  : 'userName',
                  rules: [
                    {
                      type   : 'regExp[/^[a-z0-9_-]{4,16}$/]',
                      prompt : 'Username must be a 4-16 alphanumeric characters.'
                    }
                  ]
                },
          password: {
            identifier  : 'password',
            rules: [
            {
              type   : 'empty',
              prompt : 'Please enter your desired password.'
            }
            ]
          },
          match: {
            identifier  : 'password_verify',
            rules: [
            {
              type   : 'match[password]',
              prompt : 'Password does not match. Retype your password again.'
            }
            ]
          },
       selTypeAdd: {
              identifier  : 'selTypeAdd',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please select the account type.'
                }
              ]
            },
        }
      });
  }
</script>
<div class="ui container">

  <div class="ui borderless blue inverted mini menu">
    <div class="left item" style="margin-right: 0px !important;">
      <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
        <i class="icon chevron left"></i> Back
      </button>
    </div>
    <div class="item">
      <h3><i class="user icon"></i>Accounts Setup</h3>
    </div>
    <div class="right item">
      <!-- 
      <button onclick="addModalFunc()" class="circular blue ui icon button" style="margin-right: 10px;" title="Add New Personnel">
        <i class="icon plus circle"></i>
      </button> -->
    <div class="ui right input">
      <button class="ui icon mini green button" onclick="addNew()" style="margin-right: 5px;" title="Add New Account"><i class="icon plus"></i>Add</button>
<!--       <div class="ui icon fluid input" style="width: 300px;">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div> -->
    </div>
      <!-- <div class="ui icon fluid input">
        <input id="pos_search" type="text" placeholder="Search...">
        <i class="search icon"></i>
      </div> -->


    </div>
  </div>
  <div class="ui container" style="min-height: 6190px;">
    

<!-- register success modal start -->
  <div class="ui mini modal" id="registerSuccess">
    <div class="header">
      <i class="icon check"></i> Request Sent!
    </div>
    <div class="content">
      <p>Account Added!</p>
    </div>
    <div class="actions">
      <button class="ui tiny basic button deny">Ok</button>
    </div>
  </div>

<!-- register success modal end -->

      <!-- register modal start -->
      <div class="ui tiny modal" id="regModal" style="top: 20%;">
        <div class="header"><i class="icon pencil alternate"></i> Account Request Form</div>
        <div class="content">


          <form id="registerForm" class="ui form" method="POST">
            <div class="ui grid">
              <div class="eight wide column">
                <div class="required field">
                  <label>Firstname:</label>
                  <input form="registerForm" type="text" name="firstName" placeholder="Firstname">
                </div>
                <div class="field">
                  <label>Middlename:</label>
                  <input form="registerForm" type="text" name="middleName" placeholder="Middlename">
                </div>
                <div class="required field">
                  <label>Lastname:</label>
                  <input form="registerForm" type="text" name="lastName" placeholder="Lastname">
                </div>
                <div class="field">
                  <label>Name Extension:</label>
                  <input form="registerForm" type="text" name="extName" placeholder="e.g. (Jr,Sr,II)">
                </div>
              </div>
              <div class="eight wide column">
                <div class="required field">
                  <label>Username:</label>
                  <input id="usrName" form="registerForm" type="text" name="userName" placeholder="Username">
                </div>
                <div class="required field">
                  <label>Password:</label>
                  <input form="registerForm" type="password" name="password" placeholder="Password">
                </div>
                <div class="required field">
                  <label>Retype Password:</label>
                  <input form="registerForm" type="password" name="password_verify" placeholder="Retype password">
                </div>

    <div class="required field">
      <label>Set Account Type:</label>
      <select id="selTypeAdd" class="ui dropdown" name="selTypeAdd">
        <option value="">Select Account Type</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>
              </div>
            </div>
            <div class="ui error message"></div>
          </form>


        </div>

        <div class="actions">
          <button form="registerForm" type="submit" class="ui basic small button green">Add</button>
          <button class="ui basic small button deny">Cancel</button>
        </div>

      </div>
      <!-- register modal end -->



<h4 class="ui blue header"><i class="icon bell"></i> Requests:</h4>
<table id="reqTable" class="ui teal very compact small striped table">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Username</th>
      <th>Date Requested</th>
      <!-- <th>Type</th> -->
      <th></th>
    </tr>
  </thead>
  <tbody id="user_table_request">
  </tbody>
</table>

<h4 class="ui blue header"><i class="icon check"></i> Accounts:</h4>
<table id="" class="ui teal very compact small striped table">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Username</th>
      <th>Date Requested</th>
      <th>Type</th>
      <th>Date Approved</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="user_table">
  </tbody>
</table>


<h4 class="ui blue header"><i class="icon ban"></i> Denied Request/s:</h4>
<table id="" class="ui teal very compact small striped table">
  <thead>
    <tr>
      <th></th>
      <th>Name</th>
      <th>Username</th>
      <th>Date Requested</th>
      <th>Type</th>
      <th>Date Approved</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="user_table_denied">
  </tbody>
</table>

  </div>
</div>

<div class="ui mini modal" id="modal_reqsOption">
  <div class="header">
    Confirm Request?
  </div>
  <div class="content">

  <form class="ui form" id="reqsForm" method="POST">
    <div class="field">
      <label>Set Account Type:</label>
      <select id="selType" class="ui dropdown" name="selType">
        <option value="">Select Account Type</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>
    <div class="field">
      <label>or Deny Request:</label>
      <button class="ui mini basic red fluid button" type="button" id="reqsDeny">Deny</button>
    </div>
    <div class="ui error message"></div>
  </form>
  
  </div>
  <div class="actions">
    <button form="reqsForm" type="submit" class="ui mini basic green button">Save</button>
    <button class="ui mini basic button deny">Cancel</button>
  </div>
</div>


<?php include 'footer.php'; ?>