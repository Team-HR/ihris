<?php require_once "_connect.db.php"; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Personnel Competencies Survey</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="ui/dist/semantic.css"> -->
    <script src="node_modules/vue/dist/vue.js"></script>
    <!-- <script src="jquery/jquery-3.3.1.min.js"></script> -->
    <!-- <script src="ui/dist/semantic.min.js"></script> -->
    <!-- <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css"> -->
    <!-- <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script> -->

    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <script src="semantic/dist/semantic.min.js"></script>
</head>
<style type="text/css">
    p {
        margin-left: 20px;
    }

    .active {
        color: teal !important;
        margin-left: -10px;
        font-weight: bold;
    }

    .w3-check {
        transform: scale(2);
    }

    @media print {
        .printOnly {
            display: block;
        }

        .noprint {
            display: none;
        }

        .centerPrint {
            margin: 0px;
            width: 100% !important;
        }
    }
</style>

<body>
    <script type="text/javascript">
        // window.location.reload();
        // $(document).ready(function() {
        //     // $(submittedForm);
        //     var employees_id = 0,
        //         inputName = $("#fullName"),
        //         inputDept = $("#department"),
        //         inputName_val;
        //     $('.ui.sticky').sticky({
        //         context: '#contextSurvey'
        //     });
        //     var req = <?php require_once 'autocompleteName.php'; ?>;
        //     $(inputName).autocomplete({
        //         source: req,
        //         select: function(event, ui) {
        //             if (ui.item.dateSurveyed != null) {
        //                 $("#alreadyDoneMsgContainer").html(ui.item.value);
        //                 $(alreadyDone);
        //                 // alert(ui.item.value+" already took the assessment on "+ui.item.dateSurveyed);
        //                 $(inputDept).val(ui.item.department);
        //                 // location.reload();
        //             } else {
        //                 $(inputDept).val(ui.item.department);
        //                 employees_id = ui.item.employees_id;
        //                 inputName_val = ui.item.value;
        //             }
        //         }
        //     });

        //     $(inputName).keyup(function(event) {
        //         var name_on_field = inputName.val();
        //         if (inputName_val !== name_on_field) {
        //             employees_id = 0;
        //         } else if (inputName.val() == "") {
        //             inputDept.val("");
        //         }
        //     });

        //     $('input[type="checkbox"]').on('change', function() {
        //         $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        //     });

        //     $("#comptForm").submit(function(event) {
        //         /* Act on the event */
        //         event.preventDefault();
        //         var scoresArray = [],
        //             checkUnchecked = [],
        //             name = inputName.val(),
        //             department = inputDept.val();

        //         // check if all competencies are answered start
        //         var i;
        //         for (i = 1; i <= 24; i++) {
        //             if (!$("input[name='group" + i + "[]']:checked").is(":checked")) {
        //                 // scoresArray.push("Unchecked"+i);
        //                 checkUnchecked.push("\nCompetency: " + i);
        //                 // alert("Please answer the Quesion "+i);
        //             }
        //         }
        //         // check if all competencies are answered end
        //         if (checkUnchecked.length === 0) {
        //             // if all are checked
        //             // alert("All are checked!");
        //             for (i = 1; i <= 24; i++) {
        //                 $.each($("input[name='group" + i + "[]']:checked"), function() {
        //                     scoresArray.push($(this).val());
        //                 });
        //             }
        //             // alert(employees_id);
        //             // alert(inputName.val());

        //             if (!isEmptyOrSpaces(name) && !isEmptyOrSpaces(department)) {

        //                 $.post('personnelCompetenciesSurvey_proc.php', {
        //                     success: true,
        //                     employees_id: employees_id,
        //                     inputName: name,
        //                     scoresArray: scoresArray
        //                 }, function(data, textStatus, xhr) {
        //                     $(submittedForm);
        //                 });

        //             } else {
        //                 alert('Please don\'t leave a field empty.');
        //             }
        //             // alert("Form Submitted!");

        //         } else {
        //             // if not all are checked
        //             // alert("Not all are checked! Please Check: "+checkUnchecked);
        //             $("#incompleteMsgContainer").html("Not all were answered! Please Check: " + checkUnchecked);
        //             $(incompleteForm);
        //         }
        //         // alert(scoresArray);
        //         // alert(scoresArray);
        //     });
        // });

        function isEmptyOrSpaces(str) {
            return str === null || str.match(/^ *$/) !== null;
        }


        function cancelSurvey() {
            $('#cancelSurvey').modal({
                closable: false,
                onDeny: function() {
                    // window.alert('Wait not yet!');
                    $(this).modal("close");
                    // return false;
                },
                onApprove: function() {
                    // window.alert('Approved!');
                    window.close();
                }
            }).modal('show');
        }

        function incompleteForm() {
            $('#incompleteForm').modal({
                closable: false,
                onApprove: function() {
                    $(this).modal("close");
                }
            }).modal('show');
        }

        function submittedForm() {
            // $("#submittedForm").modal({
            //   closable:false,
            //   onApprove:function(){

            //     window.scrollTo(0,0);
            // window.location.reload();
            //   }
            // }).modal('show');
            window.location.href = "personnelCompetenciesSurvey_done.php";
        }

        function alreadyDone() {
            $("#alreadyDone").modal({
                closable: false,
                onApprove: function() {
                    window.location.reload();
                }
            }).modal('show');
        }
    </script>

    <div id="alreadyDone" class="ui tiny modal">
        <div class="header">Already Done!</div>
        <div class="content">
            <p id="alreadyDoneMsgContainer" style="color: black; font-weight: normal;"></p>
        </div>
        <div class="actions">
            <div class="ui approve button blue">Back</div>
        </div>
    </div>

    <div id="submittedForm" class="ui mini modal">
        <div class="header">Success!</div>
        <div class="content">
            <p style="color: black; font-weight: normal;">Form successfully submitted for analysis. Results will be available in the personnel profile.</p>
        </div>
        <div class="actions">
            <div class="ui approve button blue">Ok</div>
        </div>
    </div>

    <div id="cancelSurvey" class="ui mini modal">
        <div class="header">Cancel Survey?</div>
        <div class="content">
            <p style="color: black; font-weight: normal;">Everything you have inputted will be trashed, unsaved and this page will ne closed. Are you sure?</p>
        </div>
        <div class="actions">
            <div class="ui approve button blue">Yes</div>
            <div class="ui cancel button red">No</div>
        </div>
    </div>

    <div id="incompleteForm" class="ui mini modal">
        <div class="header">Form Incomplete</div>
        <div class="content">
            <p id="incompleteMsgContainer" style="color: black; font-weight: normal;"></p>
        </div>
        <div class="actions">
            <div class="ui approve button blue">Back</div>
        </div>
    </div>
    <style type="text/css">
        .item {
            color: black !important;
        }

        .active {
            color: #607d8b !important;
        }
    </style>
    <!-- survey content starts here -->
    <!-- <div id="comp-vue"></div> -->


    <div class="ui fluid container">
        <div class="ui segment container" id="contextSurvey" style="width: 50%; margin-top: 50px;">
            <!-- left rail starts here -->
            <div class="left ui rail">
                <div class="ui sticky" style="width: 300px !important; height: 262.663px !important; left: 82.6px;">
                    <div class="ui segment">
                        <!-- <h3 class="ui header" style="color: #607d8b;">JOB COMPETENCY PROFILE</h3> -->
                        <div class="ui link list" style="margin-left: 20px">
                            <a href="#contextSurvey" class="item active">Top</a>
                            <a v-for="(competency, c) in competencies" :key="competency.id" :href="`#${competency.id}`" class="item" :style="form_data.competency_scores[competency.id]?'color: green !important;':''">{{`${c+1}.) ${competency.name}`}}</a>
                            <a href="#SubmitBtn" class="item">Submit</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- right rail ends here -->
            <!-- right rail starts here -->
            <div class="right ui rail">
                <div class="ui sticky" style="width: 272px !important; height: 262.663px !important; left: 1164.6px;">
                    <!-- <h3 class="ui header">Stuck Content</h3> -->
                    <div class="ui segment">
                        <button class="ui mini fluid button" onclick="window.scrollTo(0,0);"><i class="arrow alternate circle up icon large teal"></i>Top</button>
                        <br>
                        <button onclick="cancelSurvey()" class="ui mini fluid button red">Cancel / Close</button>
                        <br>
                        <button class="ui mini fluid button blue" @click="submit_form">Submit</button>
                        <br>
                        <a class="ui mini fluid button" href="#bottomPage"><i class="arrow alternate circle down icon large teal"></i>Bottom</a>
                    </div>
                </div>
            </div>
            <!-- right rail ends here -->

            <form class="ui form" id="comptForm" @submit.prevent="submit_form()">


                <div class="ui labeled fluid input">
                    <div class="ui label" style="background-color: #607d8b; color: white;">
                        Name:
                    </div>
                    <input id="fullName" type="text" name="name" placeholder="Enter Fullname..." v-model="form_data.employee_id" style="display: inline-block;">
                </div>
                <br>
                <div class="ui labeled fluid input">
                    <div class="ui label" style="background-color: #607d8b; color: white;">
                        Department:
                    </div>
                    <input id="department" class="w3-input" type="text" autocomplete="off" v-model="form_data.department_id" name="department" placeholder="Enter Department..." style="display: inline-block;">
                </div>



                <br>
                <div style="page-break-inside: avoid; font-size: 12px;">
                    <div>
                        <header class="ui block center aligned header" style="background-color: #607d8b; color: white;">
                            <h3>JOB COMPETENCY PROFILE</h3>
                        </header>
                        <div class="ui container">
                            <i style="font-size: 14px;">
                                <p>Competencies are observable abilities, skills, knowledge, motivations or traits defined in terms of the behaviors needed for successful job performance.</p>
                                <h4 style="font-weight: bold">PROFICIENCY/MASTERY LEVEL</h4>
                                <p><b>Level 1 (Introductory)</b>: Demonstrates introductory understanding and ability and, with guidance, applies the competency in a few simple situations.</p>
                                <p><b>Level 2 (Basic)</b>: Demonstrates basic knowledge and ability and, with guidance, can apply the competency in common situations that present limited difficulties.</p>
                                <p><b>Level 3 (Intermediate)</b>: Demonstrates solid knowledge and ability, and can apply the competency with minimal or no guidance in the full range of typical situations. Would require guidance to handle novel or more complex situations.</p>
                                <p><b>Level 4 (Advanced)</b>: Demonstrates advanced knowledge and ability, and can apply the competency in new or complex situations. Guides other professionals.</p>
                                <p><b>Level 5 (Expert)</b>: Demonstrates expert knowledge and ability, and can apply the competency in the most complex situations. Develops new approaches, methods or policies in the area. Is recognized as an expert, internally and/or externally. Leads the guidance of other professionals.</p>
                                <h4 style="font-weight: bold; display: inline-block;">INSTRUCTION:</h4>
                                <p style="display: inline-block;"> Please check the proficiency/mastery level of each competency classifications that qualifies.</p>
                            </i>
                        </div>
                    </div>
                </div>
                <div v-for="(competency, c) in competencies" :key="competency.id" :id="competency.id" class="section" style="page-break-inside: avoid; font-size: 12px;">
                    <br>
                    <div>
                        <header class="ui block header" style="background-color: #607d8b; color: white;">
                            <h4>{{c+1}}. {{upper_case_name(competency.name)}}</h4>
                        </header>
                        <div class="ui container">
                            <p>{{competency.description}}</p>
                            <table class="w3-table w3-bordered">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="text-align: center; vertical-align: middle;">PROFICIENCY/MASTERY LEVEL</th>
                                        <th style="text-align: center; vertical-align: middle;">BEHAVIORAL INDICATORS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(level,l) in competency.levels" :key="l">
                                        <td colspan="2" style="width: 100px; text-align: left;">
                                            <!-- <input type="radio" :value="(l+1)" class="w3-check" :name="competency.id"> -->
                                            <div class="ui checkbox">
                                                <input type="radio" :value="(l+1)" :name="competency.id" v-model="form_data.competency_scores[competency.id]">
                                                <label> <strong>LEVEL {{l+1}}</strong><br>{{level.proficiency}} </label>
                                            </div>
                                        </td>
                                        <td>
                                            <ul>
                                                <li v-for="(behavior,b) in level.behaviors" :key="b">{{behavior}}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="SubmitBtn" class="ui segment section noprint">
                    <button type="submit" class="ui fluid button blue">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>


    <!-- survey content ends here -->
    <div class="noprint" id="bottomPage"></div>

    <p class="noprint" style="text-align:center; color: grey; font-family: sans-serif;">Human Resource Information System © 2018<br>HRMO LGU Bayawan City</p>

    <script>
        var contextSurvey = new Vue({
            el: "#contextSurvey",
            data() {
                return {
                    competencies: [],
                    form_data: {
                        employee_id: "",
                        department_id: "",
                        competency_scores: {}
                    }
                }
            },
            methods: {
                upper_case_name(name) {
                    return name.toUpperCase()
                },
                submit_form() {
                    var scored_competencies = this.count_scored_competencies()
                    console.log("submit_form:", this.form_data.competency_scores);
                    console.log("count scored competencies:", scored_competencies);
                    if (scored_competencies < 24) {
                        alert("There is/are missed competency/s. Please complete all competencies.")
                    } else {
                        // save to db
                        this.save_form()
                    }
                },
                save_form() {
                    $.ajax({
                        type: "post",
                        url: "competency_assessment_form_proc.php",
                        data: {
                            save_form: true,
                            form_data: this.form_data
                        },
                        dataType: "json",
                        success: (response) => {
                            console.log(response);
                        }
                    });
                },
                scroll_location_sense() {
                    var section = document.querySelectorAll(".section");
                    var sections = {};
                    var i = 0;
                    Array.prototype.forEach.call(section, function(e) {
                        sections[e.id] = e.offsetTop;
                    });
                    window.onscroll = function() {
                        var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
                        // console.log(scrollPosition);
                        for (i in sections) {
                            if (sections[i] <= scrollPosition) {
                                document.querySelector('.active').setAttribute('class', 'item');
                                document.querySelector('a[href*=' + i + ']').setAttribute('class', 'item active');
                            }
                        }
                    };
                },
                count_scored_competencies() {
                    var count = 0;
                    $.each(this.form_data.competency_scores, (indexInArray, valueOfElement) => {
                        count += 1
                    });
                    return count;
                }
            },
            created() {
                fetch('./competencies.json')
                    .then(response => response.json())
                    .then((obj) => {
                        this.competencies = obj.competencies
                        this.$nextTick(() => {
                            $('.ui.checkbox').checkbox()
                            this.scroll_location_sense()
                        })
                    })
            },
            mounted() {
                $('.ui.sticky').sticky({
                    context: '#contextSurvey'
                });
            }
        })
    </script>
</body>

</html>