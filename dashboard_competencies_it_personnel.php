<div class="ui fluid container center aligned">
    Self-Assessed Competency Report
</div>

<table class="reportTb" style="margin-top: 50px;">
    <thead>
        <tr>
            <th class="rotate"></th>
            <th style="vertical-align: bottom;"></th>
            <th style="vertical-align: bottom;"></th>
            <th class="rotate">
                <div><span>Adaptability</span></div>
            </th>
            <th class="rotate">
                <div><span>Continous Learning</span></div>
            </th>
            <th class="rotate">
                <div><span>Communication</span></div>
            </th>
            <th class="rotate">
                <div><span>Organizational Awareness</span></div>
            </th>
            <th class="rotate">
                <div><span>Creative Thinking</span></div>
            </th>
            <th class="rotate">
                <div><span>Networking/Relationship Building</span></div>
            </th>
            <th class="rotate">
                <div><span>Conflict Management</span></div>
            </th>
            <th class="rotate">
                <div><span>Stewardship of Resources</span></div>
            </th>
            <th class="rotate">
                <div><span>Risk Management</span></div>
            </th>
            <th class="rotate">
                <div><span>Stress Management</span></div>
            </th>
            <th class="rotate">
                <div><span>Influence</span></div>
            </th>
            <th class="rotate">
                <div><span>Initiative</span></div>
            </th>
            <th class="rotate">
                <div><span>Team Leadership</span></div>
            </th>
            <th class="rotate">
                <div><span>Change Leadership</span></div>
            </th>
            <th class="rotate">
                <div><span>Client Focus</span></div>
            </th>
            <th class="rotate">
                <div><span>Partnering</span></div>
            </th>
            <th class="rotate">
                <div><span>Developing Others</span></div>
            </th>
            <th class="rotate">
                <div><span>Planning and Organizing</span></div>
            </th>
            <th class="rotate">
                <div><span>Decision Making</span></div>
            </th>
            <th class="rotate">
                <div><span>Analytical Thinking</span></div>
            </th>
            <th class="rotate">
                <div><span>Results Orientation</span></div>
            </th>
            <th class="rotate">
                <div><span>Teamwork</span></div>
            </th>
            <th class="rotate">
                <div><span>Values and Ethics</span></div>
            </th>
            <th class="rotate">
                <div><span>Visioning and Strategic Direction</span></div>
            </th>
        </tr>
    </thead>
    <tbody id="tableBody" style="margin-top: 500px;">
        <tr id="loading_el">
            <td colspan="27" style="width: 1087px; text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
                <!-- FETCHING DATA... -->
                <img src="assets/images/loading.gif" style="height: 50px; margin-top: -100px;">
                <br>
                <span>Fetching data...</span>
            </td>
        </tr>

    </tbody>
</table>


<style type="text/css">
    table {
        border-collapse: collapse;

    }

    .datatr:hover {
        background-color: #cbffc0;
    }

    td {
        /* border: 1px solid #5ea3ff; */
        text-align: center;
    }

    th.rotate {
        height: 160px;
        white-space: nowrap;
    }

    th.rotate>div {
        transform:
            translate(18px, 51px) rotate(315deg);
        width: 30px;

    }

    th.rotate>div>span {
        border-bottom: 1px solid #5ea3ff;
        padding: 5px 10px;
    }

    .reportTb table {
        width: 1008px;
    }

    .reportTb tr:nth-child(even) {
        background-color: #edf3fb;
    }
</style>

<?php require_once "_connect.db.php"; ?>
<script src="js/competencies_array.js"></script>
<script type="text/javascript">
    var dept_filters = "";
    var overallChart;
    var genderChart;

    $(document).ready(function() {
        $(load_it(['dept_id=3']))
        var loading = $('#loading_el');
        $('.popup').popup();
    });


    function load_it(filters) {
        $.post('personnelCompetenciesReport_proc.php', {
            load: true,
            filters: filters,
        }, function(data, textStatus, xhr) {
            $("#tableBody").html(data);
        });
    }
</script>