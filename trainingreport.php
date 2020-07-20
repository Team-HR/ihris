<?php 
$title = "Training Report"; 
require_once "header.php";
?>

<div class="ui container">
    <div class="ui borderless blue inverted mini menu noprint">
        <div class="left item" style="margin-right: 0px !important;">
            <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                <i class="icon chevron left"></i> Back
            </button>
        </div>
        <div class="item">
            <h3><i class="users icon"></i> Training & Feedbacking Report</h3>
        </div>
        <div class="right item">

            <div class="ui right input">
                <a href="trainingreport_gen.php" class="green ui icon mini button" title="Generate Report"
                    style="margin-right: 5px;">
                    <i class="icon print"></i> Common Trainings
                </a>
                <button onclick="print()" class="green ui icon mini button" title="Print" style="margin-right: 5px;">
                    <i class="icon print"></i> Print
                </button>

                <select id="sortYear" class="ui compact dropdown">
                    <option value="">Filter by Year</option>
                    <option value="all">All</option>
                    <?php
					include "_connect.db.php";
					$sql = "SELECT DISTINCT year(startDate) AS year FROM `personneltrainings` UNION SELECT DISTINCT year(fromDate) AS year FROM `requestandcoms` ORDER BY year DESC";
					$result = $mysqli->query($sql);
					while ($row = $result->fetch_assoc()) {
						$year = $row["year"];
						echo "<option value=\"$year\">$year</option>";
					}
					?>
                </select>

                <div style="margin-left: 5px !important;">
                    <select id="sortDept" class="ui compact fluid dropdown">
                        <option value="">Filter by Department</option>
                        <option value="all">All</option>
                        <?php
			// include "_connect.db.php";
						$sql = "SELECT * FROM `department`";
						$result = $mysqli->query($sql);
						while ($row = $result->fetch_assoc()) {
							$department_id = $row["department_id"];
							$department = $row["department"];
							echo "<option value=\"$department_id\">$department</option>";
						}
						?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="" style="padding: 20px;">
    <h2 class="ui header center aligned" id="reportDepartment" style="color: white;">All Departments of all years</h2>

    <!-- graph start -->
    <div class="ui grid center aligned">
        <div class="eight wide column">
            <div class="ui segment">
                <canvas id="performance_chart" height="70"></canvas>
            </div>
        </div>
    </div>
    <div class="ui grid">
        <div class="eight wide column">
            <div class="ui segment">
                <canvas id="graph_permanent_total" height="70"></canvas>
            </div>
            <div class="ui segment">
                <canvas id="graph_permanent" height="70"></canvas>
            </div>
        </div>
        <div class="eight wide column">
            <div class="ui segment">
                <canvas id="graph_casual_total" height="70"></canvas>
            </div>
            <div class="ui segment">
                <canvas id="graph_casual" height="70"></canvas>
            </div>
        </div>
    </div>
    <!-- graph end -->


    <div id="tbody"></div>
    <br>
    <!-- <div id="load2Container"></div> -->
    </>

    <div id="loading_el" class="ui container" style="display: none;">
        <div style="text-align: center; font-size: 32px; color: lightgrey; padding: 100px;">
            <!-- FETCHING DATA... -->
            <img src="assets/images/loading.gif"
                style="height: 50px; margin-top: -100px; margin-bottom: 20px; margin-left: 10px;">
            <br>
            <span>Generating Table...</span>
        </div>
    </div>

    <script src='./trainingreport.js'></script>
    <?php 
require_once "footer.php";
?>