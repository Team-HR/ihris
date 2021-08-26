<?php
require_once "_connect.db.php";
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
    header("location: dashboard.php?employees_id=".$_SESSION["employee_id"]);
    exit;
  // if ($_SESSION["is_admin"]) {
  //   header("location: ". $app_uri_admin);
  //   exit;
  // } else {
  //   header("location: ". $app_uri_public);
  //   exit;
  // }
} 
?>
<!DOCTYPE html>
<html>

<head>
  <title>HRMO Login</title>
  <meta charset="UTF-8" name="google" value="notranslate" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css">
  <script src="jquery/jquery-3.3.1.min.js"></script>
  <script src="ui/dist/semantic.min.js"></script>
</head>

<body class="noprint" style="
    background: url(assets/bgs/circuitboardbg.png) no-repeat center center fixed;
    -moz-background-size: cover;
    -webkit-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
">


  <script type="text/javascript">
    $(document).keypress(function(e) {
      if (e.which == 13) {
        $("#loginForm").submit();
      }
    });
    $(document).ready(function() {

      $("#loginForm").submit(function(e) {
        e.preventDefault();
        // alert();
        $(".ui.error.message").hide();
        $(".ui.warning.message").hide();
        $(".field.error").removeClass('error');
        $(".field.warning").removeClass('warning');
        $.post('login_proc.php', {
          login: true,
          username: $("#usernameInput").val(),
          password: $("#passwordInput").val()
        }, function(data, textStatus, xhr) {
          /*optional stuff to do after success */
          // alert (data);
          if (data === "01") {
            // alert("Please Enter Username and Password!");
            $("#usernameField").addClass('error');
            $("#passwordField").addClass('error');
            $("#usrAndPassMissing").show();
          } else if (data === "0") {
            // alert("Please Enter Username!");
            $("#usernameField").addClass('error');
            $("#usernameMissing").show();
          } else if (data === "1") {
            // alert("Please Enter Password!");
            $("#passwordField").addClass('error');
            $("#passwordMissing").show();
          } else if (data === "2") {
            window.location.reload();
          } else if (data === "3") {
            // alert("The password entered is not valid.");
            $("#passwordField").addClass('error');
            $("#passwordMismatch").show();
          } else if (data === "4") {
            // alert("No account found with that username.");
            $("#usernameField").addClass('error');
            $("#usernameNotFound").show();
          } else if (data === "5") {
            alert("Oops! Something went wrong. Please try again later.");
          } else if (data === "6") {
            $("#usernameField").addClass('warning');
            $("#passwordField").addClass('warning');
            $("#accountApproval").show();
            // alert("Account is not approved yet! Please ask the HRMO admin for approval.");
          } else if (data === "7") {
            $("#accountDenied").show();
            // alert("Account is not approved yet! Please ask the HRMO admin for approval.");
          }
        });
      });

      $('#submitBtn').popup();
      $("#regBtn").unbind().click(function(event) {
        $("#regModal").modal({
          closable: false,
          allowMultiple: false,
          onDeny: function() {
            $(clear_inputs);
          }
        }).modal("show");
      }).popup();

      $("#frgtBtn").popup({
        on: 'click'
      });


      $('#registerForm').form({
        on: 'submit',
        // inline: true,
        // transition: 'drop',
        onSuccess: function(event, fields) {
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
            if (data == "0") {
              // $("#regModal").modal("hide");
              $("#registerSuccess").modal({
                closable: false,
                allowMultiple: false,
                onDeny: function() {
                  location.reload();
                }
              }).modal("show");
              $("input[name='firstName']").val("");
              $("input[name='middleName']").val("");
              $("input[name='lastName']").val("");
              $("input[name='extName']").val("");
              $("input[name='userName']").val("");
              $("input[name='password']").val("");
              $("input[name='password_verify']").val("");
              console.log(data);
              // location.reload();
            } else if (data == "1") {
              console.log(data);
              $("#registerForm").form("add errors", ["Username is already taken! Please re-enter a different one."]);
              $("#registerForm").form("add prompt", "userName", ["Username is already taken! Please re-enter a different one."]);
            }
            // alert(data);
          });

        },
        fields: {
          firstName: {
            identifier: 'firstName',
            rules: [{
              type: 'empty',
              prompt: 'Please enter your firstname.'
            }]
          },
          lastName: {
            identifier: 'lastName',
            rules: [{
              type: 'empty',
              prompt: 'Please enter your lastname.'
            }]
          },
          regex: {
            identifier: 'userName',
            rules: [{
              type: 'regExp[/^[a-z0-9_-]{4,16}$/]',
              prompt: 'Username must be a 4-16 alphanumeric characters.'
            }]
          },
          password: {
            identifier: 'password',
            rules: [{
              type: 'empty',
              prompt: 'Please enter your desired password.'
            }]
          },
          match: {
            identifier: 'password_verify',
            rules: [{
              type: 'match[password]',
              prompt: 'Password does not match. Retype your password again.'
            }]
          },
        }
      });
    });


    function clear_inputs() {
      // $("input").each(function(index, el) {
      //   console.log(el);
      //   $(el).val("");
      // });
      location.reload();
    }
  </script>


  <div class="ui mini modal" id="registerSuccess">
    <div class="header">
      <i class="icon check"></i> Request Sent!
    </div>
    <div class="content">
      <p>Please wait for HRMO's approval.</p>
    </div>
    <div class="actions">
      <button type="button" class="ui tiny basic button deny">Ok</button>
    </div>
  </div>

  <div class="ui mini container" style="width: 300px; padding-top: 100px;">
    <form id="loginForm">
      <div class="ui form blue stacked segment">
        <!-- <div style="text-align: center; padding: 30px; color: #23193e;">
            <i class="large icon users circle" style="transform: scale(4);"></i>
          </div> -->
        <div style="text-align: center;">
          <img src="favicon.ico" style="width: 150px; margin-bottom: 20px;">
          <h3 class="ui header">Login IHRIS</h3>
        </div>
        <!-- <div class="two fields"> -->
        <div id="usernameField" class="field">
          <label>Username:</label>
          <input id="usernameInput" placeholder="Username" type="text" autofocus autocomplete>
        </div>
        <div id="passwordField" class="field">
          <label>Password:</label>
          <input id="passwordInput" placeholder="Password" type="password" autofocus autocomplete>
        </div>
        <!-- </div> -->
        <button id="submitBtn" type="submit" class="ui submit basic button blue" data-content="Login to an existing account" data-position="bottom left"><i class="icon sign-in"></i> Login</button>
        <!-- <button id="regBtn" type="button" class="ui submit basic button green" data-content="Request for an account" data-position="bottom left"><i class="icon pencil alternate"></i> Register</button> -->
        <div style="margin-top: 15px; text-align: right;">
          <!-- <a id="frgtBtn" style="color: grey; cursor: pointer;" data-title="Account Recovery" data-content="Please ask the HRMO admin for account recovery." data-position="bottom left">Forgot your account?</a> -->
        </div>

        <div id="usrAndPassMissing" class="ui error message">
          <div class="header">Empty Fields!</div>
          <p>Please enter the username and password.</p>
        </div>
        <div id="usernameMissing" class="ui error message">
          <div class="header">Empty Username!</div>
          <p>Please enter the Username.</p>
        </div>
        <div id="passwordMissing" class="ui error message">
          <div class="header">Empty Password!</div>
          <p>Please enter the password.</p>
        </div>
        <div id="passwordMismatch" class="ui error message">
          <div class="header">Password Invalid!</div>
          <p>The password does not match.</p>
        </div>
        <div id="usernameNotFound" class="ui error message">
          <div class="header">Username Invalid!</div>
          <p>Username does not exist.</p>
        </div>
        <div id="accountApproval" class="ui warning message">
          <div class="header">Approval Needed!</div>
          <p>The account is not approved yet! Please ask the HRMO admin for approval.</p>
        </div>
        <div id="accountDenied" class="ui error message">
          <div class="header">Account Denied!</div>
          <p>The account has been denied access! Please ask the HRMO admin for approval.</p>
        </div>
      </div>
    </form>
  </div>

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
          </div>
        </div>
        <div class="ui error message"></div>
      </form>


    </div>

    <div class="actions">
      <button class="ui basic small button red deny">Cancel</button>
      <button form="registerForm" type="submit" class="ui basic small button green">Request</button>
    </div>

  </div>
  <!-- register modal end -->


</body>

</html>