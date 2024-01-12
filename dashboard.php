<?php
$employees_id = $_GET["employees_id"];

require_once "_connect.db.php";
require_once "header.php";
require_once "employeeinfo.v2.ajax.php";
require_once "libs/Auth.php";

$auth = new Auth;
// echo json_encode($_SESSION);
// echo "<br>";
// echo json_encode($auth->is_hr);
if (isset($_GET["spms"])) {
?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#rsp").removeClass('active');
            $("#rsp0").removeClass('active');
            $("#spms").addClass('active');
            $("#spms0").addClass('active');
            $("#spms01").removeClass('active');
            $("#spms02").addClass('active');
        });
    </script>
<?php
}
?>

<div id="saveMsg" class="" style="top: 15px; display: none; position: fixed; z-index: 10; width: 100%; left: 0; text-align: center;">
    <div class="ui center green inverted aligned segment" style="width: 100px; margin-left: auto; margin-right: auto;">
        <i class="checkmark icon"></i> Saved!
    </div>
</div>
<!-- custom sidebar start -->
<div id="editModal" class="ui modal">
    <!-- <i class="close icon"></i> -->
    <div class="header">
        Edit Personnel Profile
    </div>
    <div class="image content">
        <form class="ui form">
            <div class="field">
                <label>Name:</label>
                <div class="four fields">
                    <div class="five wide field">
                        <input id="firstNameModal" type="text" placeholder="First Name">
                    </div>
                    <div class="five wide field">
                        <input id="middleNameModal" type="text" placeholder="Middle Name">
                    </div>
                    <div class="five wide field">
                        <input id="lastNameModal" type="text" placeholder="Last Name">
                    </div>
                    <div class="three wide field">
                        <input id="extNameModal" type="text" placeholder="ext.">
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="three wide field">
                    <label>Status:</label>
                    <div class="ui selection dropdown compact" id="editStat_drop">
                        <input type="hidden" name="status">
                        <i class="dropdown icon"></i>
                        <div class="default text">Active/Inactive</div>
                        <div class="menu">
                            <div class="item" data-value="ACTIVE">Active</div>
                            <div class="item" data-value="INACTIVE">Inactive</div>
                        </div>
                    </div>
                </div>
                <div class="four wide field">
                    <label>Date Active/Inactive:</label>
                    <input type="date" name="" id="editStat_date">
                </div>
                <div class="four wide field">
                    <label>IPCR Starts/Started In:</label>
                    <input type="date" name="" id="editStat_dateIPCR">
                </div>
            </div>
            <div class="fields">
                <div class="four wide field">
                    <label>Gender:</label>
                    <select id="genderModal" class="ui fluid dropdown genderModal">
                        <option value="">Gender</option>
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </select>
                </div>
                <div class="three wide field">
                    <label>ID No.</label>
                    <input id="employees_idModal" type="text" name="employees_id" readonly="">
                </div>
                <div class="four wide field">
                    <label>Status:</label>
                    <select id="employmentStatusModal" class="ui fluid dropdown">
                        <option value="">Select Status</option>
                        <option value="CASUAL">CASUAL</option>
                        <option value="PERMANENT">PERMANENT</option>
                        <option value="ELECTIVE">ELECTIVE</option>
                        <option value="COTERMINUS">COTERMINUS</option>
                    </select>

                </div>
                <div class="six wide field">
                    <label>Nature of Assignemt:</label>
                    <select id="natureOfAssignmentModal" class="ui fluid dropdown natureOfAssignmentModal">
                        <option value="">Select Rank</option>
                        <option value="RANK & FILE">RANK AND FILE</option>
                        <option value="SUPERVISORY">SUPERVISORY</option>
                    </select>
                </div>
            </div>
            <div class="fields">
                <div class="sixteen wide field">
                    <label>Assigned Office:</label>
                    <select id="departmentModal">
                        <?php $resultDepts = $mysqli->query("SELECT * FROM `department` ORDER BY `department` ASC");
                        while ($resultsDeptsArray = mysqli_fetch_array($resultDepts)) {
                            print "<option value=\"{$resultsDeptsArray['department_id']}\">{$resultsDeptsArray['department']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="fields">
                <div class="sixteen wide field">
                    <label>Position:</label>
                    <select id="positionModal" class="ui search normal">
                        <?php $result = $mysqli->query("SELECT * FROM `positiontitles` ORDER BY `position` ASC");
                        while ($row = $result->fetch_assoc()) {
                            $position_id = $row["position_id"];
                            $position = $row["position"];
                            if ($row["functional"] == "") {
                                $functional = $row["functional"];
                            } else {
                                $functional = " - " . $row["functional"];
                            }
                            print "<option value=\"{$position_id}\">$position $functional</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <div class="ui mini deny button">
            Cancel
        </div>
        <div class="ui mini approve blue right labeled icon button">
            Save
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>

<div class="ui fluid container" style="min-height: 600px; padding: 5px;">
    <!-- auth user info start -->
    <div class="ui container" id="auth_user_app">
        <template>
            <div class="ui borderless blue inverted mini menu">
                <div class="left item" style="margin-right: 0px !important;">

                </div>
                <div class="item">
                    <h3 style="color: white;"><i class="user circle icon"></i> <i id="employeeName"></i></h3>
                </div>
                <div class="right item">
                    <!-- <button onclick="editModalFunc()" class="ui right floated blue button" style="padding: 10px 10px; font-size: 10px;"><i class="ui icon edit"></i> Edit</button> -->
                </div>
            </div>

            <div class="ui container" style="padding: 5px; width: 1300px;">
                <style type="text/css">
                    .actives {
                        background-color: #f2f2f2;
                        color: #4075a9;
                    }

                    .ui.tab.segment {
                        min-height: 300px;
                    }
                </style>
                <table class="ui very compact small celled table" style="font-size: 12px;">
                    <tr>
                        <td class="actives">STATUS:</td>
                        <td id="status">{{user.status}}</td>
                        <td class="actives">SINCE:</td>
                        <td id="statusDate">{{user.statusDateStr}}</td>
                        <td class="actives">IPCR STARTS/STARTED IN:
                        </td>
                        <td id="dateIPCRView">{{user.dateIPCRView}}</td>
                    </tr>
                    <tr>
                        <td class="actives">ID:</td>
                        <td id="employees_idView">{{user.employees_id_padded}}</td>
                        <td class="actives">ASSIGNED OFFICE:</td>
                        <td id="departmentView">{{user.department}}</td>
                        <td class="actives">LEVEL:</td>
                        <td id="levelView">{{user.level}}</td>
                    </tr>
                    <tr>
                        <td class="actives">GENDER:</td>
                        <td id="genderView">{{user.gender}}</td>
                        <td class="actives">POSITION:</td>
                        <td id="positionView">{{user.position}}</td>
                        <td class="actives">CATEGORY:</td>
                        <td id="categoryView">{{user.category}}</td>
                    </tr>
                    <tr>
                        <td class="actives">STATUS:</td>
                        <td id="employmentStatusView">{{user.employmentStatus}}</td>
                        <td class="actives">NATURE OF ASSIGNMENT:</td>
                        <td id="natureOfAssignmentView">{{user.natureOfAssignment}}</td>
                        <td class="actives">SALARY GRADE:</td>
                        <td id="salaryGradeView">{{user.salaryGrade}}</td>
                    </tr>
                </table>
            </div>
        </template>
    </div>
    <!-- auth user info end -->
    <div class="" style="padding: 5px; width: 1500px; margin: auto;">
        <div class="ui segment grid">
            <div class="three wide column">
                <div id="pim-menu" class="ui vertical pointing menu fluid">
                    <a class="item active" data-tab="pds">
                        PDS
                    </a>
                    <a class="item" data-tab="personality">
                        Personality
                    </a>
                    <a class="item" data-tab="competencies">
                        Competencies
                    </a>
                    <a class="item" data-tab="calendar">
                        Calendar
                    </a>
                    <a class="item" data-tab="appointments">
                        Appointment
                    </a>
                    <a class="item" data-tab="service_records">
                        Service Records
                    </a>
                    <a class="item" data-tab="leave_records">
                        Leave Records
                    </a>
                    <a class="item" data-tab="hr_cores">
                        HR CORES
                    </a>
                </div>
            </div>
            <div class="thirteen wide stretched column">
                <div class="ui tab" data-tab="personality">
                    <div class="ui pointing secondary blue menu fluid" id="competencies">
                        <a class="item active" data-tab="myersBriggsIndicator">
                            Myers-Briggs Type Indicator
                        </a>
                    </div>
                    <div class="ui tab segment active" data-tab="myersBriggsIndicator">
                        <h3 style="text-align: center;">MYERS-BRIGGS TYPE INDICATOR</h3>
                        <!-- <span>Results will be shown here</span> -->
                        <?php
                        require "mbti_dashboard.php"
                        ?>
                    </div>
                </div>
                <div class="ui tab" data-tab="competencies">
                    <div class="ui pointing secondary blue menu fluid" id="competencies">
                        <a class="item <?php echo $_SESSION['employee_id'] == '21919' ? '' : 'active' ?>" data-tab="self_assessed">
                            Self Assessment
                        </a>
                        <?php if ($_SESSION['supervisory']) { ?>
                            <a class="item" data-tab="subordinates">
                                Subordinates
                            </a>
                        <?php } ?>
                        <?php if ($_SESSION['employee_id'] == '21919') { ?>
                            <a class="item active" data-tab="it_personnel" style="color: purple !important;">
                                IT Personnel
                            </a>
                        <?php } ?>
                    </div>
                    <div class="ui tab segment <?php echo $_SESSION['employee_id'] == '21919' ? '' : 'active' ?>" data-tab="self_assessed">
                        <?php
                        require_once "dashboard_competencies_self_assessment.php";
                        ?>
                    </div>
                    <div class="ui tab segment" data-tab="subordinates">
                        <?php
                        require_once "dashboard_competencies_subordinates.php";
                        ?>
                    </div>

                    <?php if ($_SESSION['employee_id'] == '21919') { ?>
                        <div class="ui tab segment active" data-tab="it_personnel">
                            <?php
                            require_once "dashboard_competencies_it_personnel.php";
                            ?>
                        </div>
                    <?php } ?>


                </div>

                <div class="ui tab" data-tab="calendar">
                    <div class="ui segment">
                        <!-- <h2>Calendar</h2>
                        <hr> -->
                        <!-- calendar start -->
                        <?php
                        require "dashboard_calendar.php"
                        ?>
                        <!-- calendar end -->
                    </div>

                </div>
                <div class="ui tab" data-tab="appointments" id="appointment-app">
                    <div class="ui pointing secondary blue menu fluid" id="pds">
                        <a class="item active" data-tab="appointment_history">Appointment History</a>
                    </div>
                    <div class="ui tab segment active" data-tab="appointment_history">
                        <!-- <a href="appointments.php" class="mini teal ui button right floated"><i class="icon edit"></i> Edit</a> 
                        <br> -->
                        <table class="ui very small compact structured celled table">
                            <thead>
                                <tr class="center aligned">
                                    <th>Office</th>
                                    <th>Position</th>
                                    <th>Function</th>
                                    <th>Date of Appointment</th>
                                    <th>Nature of Appointment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(appointment,key) in appointments">
                                    <tr class="center aligned" :key="key">
                                        <td>{{appointment.department}}</td>
                                        <td>{{appointment.position}}</td>
                                        <td>{{appointment.functional}}</td>
                                        <td>{{appointment.date_of_appointment}}</td>
                                        <td>{{appointment.nature_of_appointment}}</td>
                                    </tr>
                                </template>
                                <template>
                                    <tr v-if="!appointments.length" class="center aligned">
                                        <td colspan="6" style="color: grey"> -- No Data --</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ui tab active" data-tab="pds">
                    <div class="ui pointing secondary blue menu fluid" id="pds">
                        <a class="item active" data-tab="personal">Personal</a>
                        <a class="item" data-tab="family">Family</a>
                        <a class="item" data-tab="education">Education</a>
                        <a class="item" data-tab="eligibility">Eligibility</a>
                        <a class="item" data-tab="work_experience">Work Experiences</a>
                        <a class="item" data-tab="voluntary_works">Voluntary Works</a>
                        <a class="item" data-tab="trainings">Trainings</a>
                        <a class="item" data-tab="other_information">Other Information</a>
                    </div>
                    <div class="ui tab segment active" data-tab="personal">
                        <?php require 'pds_personal.php' ?>
                    </div>
                    <div class="ui tab segment" data-tab="family">
                        <?php require 'pds_family.php'; ?>
                    </div>
                    <div class="ui tab segment" data-tab="education">
                        <?php require 'pds_education.php'; ?>
                    </div>
                    <div class="ui tab segment" data-tab="eligibility">
                        <?php require 'pds_eligibility.php' ?>
                    </div>
                    <div class="ui tab segment" data-tab="work_experience">
                        <?php require 'pds_work_experience.php' ?>
                    </div>
                    <div class="ui tab segment" data-tab="voluntary_works">
                        <?php require 'pds_voluntary.php' ?>
                    </div>
                    <div class="ui tab segment" data-tab="trainings">
                        <?php require 'pds_trainings.php' ?>
                    </div>
                    <div class="ui tab segment" data-tab="other_information">
                        <?php require 'pds_other_information.php' ?>
                    </div>
                </div>
                <div class="ui tab" data-tab="service_records">

                    <div class="ui pointing secondary blue menu fluid" id="">
                        <a class="item active" data-tab="service_recs">Service Records</a>
                    </div>
                    <div class="ui tab segment active" data-tab="service_recs">
                        <?php require_once "service_record_dash.php"; ?>
                    </div>

                </div>
                <div id="dashboard_leave_records" class="ui tab" data-tab="leave_records">
                    <template>
                        <div class="ui pointing secondary blue menu fluid" id="">
                            <a class="item active" data-tab="attendance_report">Attendance Report</a>
                        </div>
                        <div class="ui tab segment active" data-tab="attendance_report">
                            <div style="text-align: center;">
                                <table class="ui celled compact structured table">
                                    <thead>
                                        <tr class="center aligned">
                                            <th>Month - Year</th>
                                            <th>Tardy<br>(min)</th>
                                            <th>Undertime<br>(min)</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(rec, k) in leave_records" :key="k">
                                            <td>{{rec.month}}</td>
                                            <td class="center aligned">{{rec.totalMinsTardy}}</td>
                                            <td class="center aligned">{{rec.totalMinsUndertime}}</td>
                                            <td>{{rec.remarks}}</td>
                                        </tr>
                                        <tr v-if="!leave_records.length">
                                            <td colspan="4" class="center aligned">
                                                <p style="padding: 20px; background-color: lightgrey; color: white;">No Data</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="ui tab" data-tab="hr_cores">

                    <!-- <div class="ui pointing secondary blue menu fluid">
                        <a class="item active" data-tab="leave_recs">Leave Records</a>
                    </div>
                    <div class="ui tab segment active" data-tab="leave_recs">
                        <div style="text-align: center;">
                            <p style="padding: 20px; background-color: lightgrey; color: white;">No Data</p>
                        </div>
                    </div> -->

                    <div id="context1">
                        <div class="ui pointing secondary blue menu fluid">
                            <a id="rsp" class="item active" data-tab="first">RSP</a>
                            <a class="item" data-tab="second">L&D</a>
                            <a id="spms" class="item" data-tab="third">SPMS</a>
                            <a class="item" data-tab="fourth">R&R</a>
                        </div>
                        <div id="rsp0" class="ui bottom attached tab segment active" data-tab="first">
                            <h3 class="ui header block primary">Recruitment, Selection and Placement</h3>
                            <div class="ui container segment">
                                <div class="ui grid">
                                    <div class="eight wide column">
                                        <canvas id="comptChart" height="210"></canvas>
                                    </div>
                                    <div class="eight wide column">
                                        <canvas id="ldnLsaChart" height="210"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="ui pointing secondary blue menu">
                                <a class="active item" data-tab="first/a">Competency Profile</a>
                                <a class="item" data-tab="first/b">Learning Style</a>
                            </div>
                            <div class="ui active tab segment" data-tab="first/a">
                                <?php
                                require_once "_connect.db.php";
                                $employees_id = $_GET["employees_id"];
                                $sql = "SELECT * FROM `competency` WHERE `employees_id` = '$employees_id'";
                                $result = $mysqli->query($sql);

                                if ($result->num_rows != 0) {

                                    $row = $result->fetch_array(MYSQLI_NUM);
                                    $comptScores = array();

                                    for ($i = 3; $i < 27; $i++) {
                                        array_push($comptScores, $row[$i]);
                                    }

                                    $serializedComptScore = serialize($comptScores);
                                } else {
                                    $serializedComptScore = null;
                                }

                                if (empty($serializedComptScore)) {
                                ?>
                                    <div style="text-align: center;">
                                        <p style="padding: 20px; background-color: lightgrey; color: white;">Personnel has not yet
                                            taken the survey.</p>
                                    </div>
                                <?php
                                }
                                // } else {
                                require "employeeinfo_competencyProfile.php";
                                // }
                                ?>
                            </div>
                            <div class="ui tab segment" data-tab="first/b">

                                <?php

                                $employees_id = $_GET["employees_id"];
                                $sql = "SELECT * FROM `ldn_lsa` WHERE `employees_id` = '$employees_id'";
                                $result = $mysqli->query($sql);
                                $lsa_rows = $result->num_rows;
                                if (!$lsa_rows) {
                                    # code...
                                ?>
                                    <div style="text-align: center;">
                                        <p style="padding: 20px; background-color: lightgrey; color: white;">Personnel has not yet
                                            taken the survey.</p>
                                    </div>
                                <?php
                                    $activist = 0;
                                    $reflector = 0;
                                    $theorist = 0;
                                    $pragmatist = 0;
                                } else {
                                    $row = $result->fetch_assoc();
                                    $activist = $row['activist'];
                                    $reflector = $row['reflector'];
                                    $theorist = $row['theorist'];
                                    $pragmatist = $row['pragmatist'];
                                    $date_surveyed = $row['date_surveyed'];
                                }
                                require_once "employeeinfo_ldn_lsa.php";
                                ?>

                            </div>
                        </div>
                        <div class="ui bottom attached tab segment" data-tab="second">
                            <h3 class="ui header block primary">Learning and Development</h3>
                            <div class="ui pointing secondary blue menu">
                                <a class="item active" data-tab="second/a">Interventions Attended</a>
                            </div>
                            <div class="ui tab segment active" data-tab="second/a">
                                <?php
                                require_once "employeeinfo_trainingsAttended_for_dashboard.php";
                                ?>
                            </div>
                        </div>
                        <div id="spms0" class="ui bottom attached tab segment" data-tab="third">
                            <h3 class="ui header block primary">Strategic Performance Management System</h3>
                            <div class="ui pointing secondary blue menu">
                                <!-- <a id="spms01" class="item active" data-tab="third/a">Individual Development Plan</a> -->
                                <a id="spms02" class="item" data-tab="third/b">IPCR(Recommendation Portion)</a>
                                <a class="item" data-tab="third/c">Coaching and Mentoring</a>
                                <!-- <a class="item" data-tab="third/d">Feedback Mechanism</a> -->
                            </div>
                            <!-- <div class="ui tab segment active" data-tab="third/a">
                                Individual Development Plan will be implemented here...
                            </div> -->
                            <div class="ui tab segment" data-tab="third/b">
                                <?php
                                // for IPCR (Reccomendation Portion)
                                require_once "umbra/IDP/idpTable.php";
                                ?>
                            </div>
                            <div class="ui tab segment" data-tab="third/c">
                                <!-- Coaching and Mentoring will be implemented here... -->
                                <?php
                                require_once "umbra/cmr/empCrmInfo.php";
                                ?>
                            </div>
                            <!-- <div class="ui tab segment" data-tab="third/d">
                                Feedback Mechanism will be implemented here...
                            </div> -->
                        </div>
                        <div class="ui bottom attached tab segment" data-tab="fourth">
                            <h3 class="ui header block primary">Rewards and Recognition</h3>
                            <div class="ui fluid segment">
                                <div style="text-align: center;">
                                    <p style="padding: 20px; background-color: lightgrey; color: white;">No Data</p>
                                </div>
                            </div>
                            <!-- <div class="ui pointing secondary blue menu">
                                <a class="item active" data-tab="fourth/a"></a>
                                <a class="item" data-tab="fourth/b">4B</a>
                                <a class="item" data-tab="fourth/c">4C</a>
                            </div>
                            <div class="ui tab segment active" data-tab="fourth/a">
                            </div>
                            <div class="ui tab segment" data-tab="fourth/b">4B</div>
                            <div class="ui tab segment" data-tab="fourth/c">4C</div> -->
                        </div>
                    </div>

                    <!-- </div> -->

                </div>
            </div>
        </div>
    </div>



    <!-- scripts -->
    <!-- auth_user_app script -->
    <script src="dashboard.js"></script>
    <script src="dashboard_leave_records.js"></script>
    <script src="pds/config.js"></script>
    <script src="appointments/config.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(load);
            $("#editStat_drop").dropdown();
            $("#genderModal").dropdown();
            $("#natureOfAssignmentModal").dropdown();
            $("#departmentModal").dropdown();
            $("#positionModal").dropdown({
                fullTextSearch: true,
            });
            $('#context1 .menu .item').tab({
                context: $('#context1')
            })
        });

        function editModalFunc() {
            $("#editModal").modal({
                onDeny: function() {
                    $(load);
                },
                onApprove: function() {
                    $(update);
                    // save msg animation start
                    $("#saveMsg").transition({
                        animation: 'fly down',
                        onComplete: function() {
                            setTimeout(function() {
                                $("#saveMsg").transition('fly down');
                            }, 1000);
                        }
                    });
                    // save msg animation end
                }
            }).modal("show");
        }

        function load() {
            $.post('employeeinfo.v2.ajax.php', {
                loadProfile: true,
                employees_id: <?php echo $employees_id; ?>
            }, function(data, textStatus, xhr) {
                var array = jQuery.parseJSON(data);
                // alert(array.employees_id);
                var full_name = array.fullname
                $("#employeeName").html(full_name);
                document.title = full_name
                $("#firstNameModal").val(array.firstName);
                $("#middleNameModal").val(array.middleName);
                $("#lastNameModal").val(array.lastName);
                $("#extNameModal").val(array.extName);
                $("#genderModal").val(array.gender).change();
                $("#employees_idModal").val(array.employees_id);
                $("#editStat_drop").dropdown("set selected", array.status);
                $("#editStat_date").val(array.statusDate);
                $("#editStat_dateIPCR").val(array.dateIPCR);
                $("#employmentStatusModal").dropdown("set selected", array.employmentStatus);
                $("#natureOfAssignmentModal").val(array.natureOfAssignment).change();
                $("#departmentModal").val(array.department_id).change();
                $("#positionModal").val(array.position_id).change();
                $("#categoryModal").val(array.category);
                $("#levelModal").val(array.level);
                $("#salaryGradeModal").val(array.salaryGrade);
            });
        }

        function update() {
            $.post('employeeinfo.v2.ajax.php', {
                update: true,
                employees_id: <?php echo $employees_id; ?>,
                firstName: $("#firstNameModal").val(),
                middleName: $("#middleNameModal").val(),
                lastName: $("#lastNameModal").val(),
                extName: $("#extNameModal").val(),
                status: $("#editStat_drop").dropdown("get value"),
                statusDate: $("#editStat_date").val(),
                dateIPCR: $("#editStat_dateIPCR").val(),
                gender: $("#genderModal").val(),
                employmentStatus: $("#employmentStatusModal").dropdown("get value"),
                natureOfAssignment: $("#natureOfAssignmentModal").val(),
                department_id: $("#departmentModal").val(),
                position_id: $("#positionModal").val()
            }, function(data, textStatus, xhr) {
                // console.log(data);
                /*optional stuff to do after success */
                $(load);
            });

        }
    </script>

    <!-- styles -->
    <style>
        .actives {
            background-color: #2185d0;
            color: white;
            text-align: right !important;
        }

        .readOnlyEdu {
            border: 0px solid white !important;
            padding: 0px !important;
        }

        .editState {
            background-color: #ffffb05c !important;
        }

        .readOnly {
            border: 1px solid white !important;
            border-bottom: 1px solid lightgrey !important;
            border-radius: 0px !important;
        }
    </style>
    <?php require_once "footer.php"; ?>