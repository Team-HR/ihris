<?php
require "_connect.db.php";

if (isset($_POST["getTrainings"])) {

  $json = array();
  $inside_json = array();

  $sql = "SELECT * FROM `trainings`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $training_id = $row["training_id"];
    $training = $row["training"];

    $inside_json = array('title' => $training);
    array_push($json, $inside_json);
  }
  echo json_encode($json);
} elseif (isset($_POST["get_prr"])) {
  $data = array();
  $sql = <<<SQL

SELECT
	employees.employees_id,
	UPPER(CONCAT( employees.lastName, ', ', employees.firstName, ' ', employees.middleName, ' ', employees.extName )) AS fullName,
	CONCAT_WS(', ',prr.period, prr.year) AS period,
	prr.type,
	prrlist.comments 
FROM
	employees
	LEFT JOIN prrlist ON employees.employees_id = prrlist.employees_id
	LEFT JOIN prr ON prrlist.prr_id = prr.prr_id
WHERE
	employees.`status` = 'ACTIVE' 
	-- AND prrlist.comments <> '' 
ORDER BY
	employees.lastName ASC,
	prr.period DESC
  
SQL;

  $result = $mysqli->query($sql);

  // $data_raw = array();
  // $existing = false;
  $id0 = 'id_0';
  while ($row = $result->fetch_assoc()) {

    // $data[] = $row;
    $id = $row['employees_id'];
    $prr = [
      'period' => $row['period'],
      'type' => $row['type'],
      'comments' => $row['comments']
    ];

    if (!array_key_exists('id_' . $id, $data)) {
      $data['id_' . $id] = [
        'id' => $id,
        'fullName' => $row['fullName'],
        'prr' => [$prr]
      ];
      // $id0 = 'id_'.$id;
    } else $data['id_' . $id]['prr'][] = $prr;
  }

  echo json_encode($data);
} elseif (isset($_POST["addNew"])) {

  $currentDate = date('Y-m-d H:i:s');
  $department_id = $_POST["department_id"];
  $manager_arr = $_POST["manager_arr"];
  $staff_arr = $_POST["staff_arr"];
  $all_arr = $_POST["all_arr"];
  $tools_arr = $_POST["tools_arr"];

  $manager_arr_sql = array();
  $staff_arr_sql = array();
  $all_arr_sql = array();
  $tools_arr_sql = array();

  foreach ($manager_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($manager_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($manager_arr_sql, $training_id);
    }
  }

  foreach ($staff_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($staff_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($staff_arr_sql, $training_id);
    }
  }

  foreach ($all_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($all_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($all_arr_sql, $training_id);
    }
  }


  foreach ($tools_arr as $tool) {
    array_push($tools_arr_sql, addslashes($tool));
  }


  $manager_arr_sql = serialize($manager_arr_sql);
  $staff_arr_sql = serialize($staff_arr_sql);
  $all_arr_sql = serialize($all_arr_sql);
  $tools_arr_sql = addslashes(serialize($tools_arr_sql));


  $sql = "INSERT INTO `tna` (`department_id`, `manager_trs`, `staff_trs`, `all_trs`, `tools`) VALUES ('$department_id', '$manager_arr_sql', '$staff_arr_sql', '$all_arr_sql', '$tools_arr_sql')";
  $mysqli->query($sql);
} elseif (isset($_POST["load"])) {
  $sql = "SELECT * FROM `tna`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $tna_id = $row["tna_id"];
    $department_id = $row["department_id"];
    $sql1 = "SELECT `department` FROM `department` WHERE `department_id` = '$department_id'";
    $result1 = $mysqli->query($sql1);
    $row1 = $result1->fetch_assoc();
    $department = $row1["department"];
    $manager_trs = unserialize($row["manager_trs"]);
    $staff_trs = unserialize($row["staff_trs"]);
    $all_trs = unserialize($row["all_trs"]);
    $tools = unserialize($row["tools"]);
?>

    <div class="ui container depts" id="<?php echo $department_id; ?>" style="margin-bottom: 10px;">
      <div class="ui blue basic segment">
        <div class="ui mini borderless menu">
          <div class="item">
            <h3><?php echo $department; ?></h3>
          </div>
          <div class="right item">
            <button class="ui icon basic button" onclick="edit('<?php echo $tna_id; ?>')" style="margin-right: 5px;"><i class="icon edit"></i>Edit</button>
          </div>
        </div>


        <div class="ui grid">
          <div class="four wide column">
            <h5 class="ui header center aligned">Manager</h5>

            <div class="ui celled list">
              <?php
              if ($manager_trs != null) {
                foreach ($manager_trs as $training_id) {
                  $sql2 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
                  $result2 = $mysqli->query($sql2);
                  $row2 = $result2->fetch_assoc();
                  $training = $row2["training"];
              ?>
                  <div class="item">
                    <div class="content">
                      <?php echo $training; ?>
                    </div>
                  </div>
              <?php
                }
              } else {
                echo "<div style='color:lightgrey; text-align: center;'>None</div>";
              }
              ?>
            </div>
          </div>
          <div class="four wide column">
            <h5 class="ui header center aligned">Staff</h5>
            <div class="ui celled list">
              <?php
              if ($staff_trs != null) {
                foreach ($staff_trs as $training_id) {
                  $sql2 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
                  $result2 = $mysqli->query($sql2);
                  $row2 = $result2->fetch_assoc();
                  $training = $row2["training"];
              ?>
                  <div class="item">
                    <div class="content">
                      <?php echo $training; ?>
                    </div>
                  </div>
              <?php
                }
              } else {
                echo "<div style='color:lightgrey; text-align: center;'>None</div>";
              }
              ?>
            </div>
          </div>
          <div class="four wide column">
            <h5 class="ui header center aligned">All</h5>
            <div class="ui celled list">
              <?php
              if ($all_trs != null) {
                foreach ($all_trs as $training_id) {
                  $sql2 = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
                  $result2 = $mysqli->query($sql2);
                  $row2 = $result2->fetch_assoc();
                  $training = $row2["training"];
              ?>
                  <div class="item">
                    <div class="content">
                      <?php echo $training; ?>
                    </div>
                  </div>
              <?php
                }
              } else {
                echo "<div style='color:lightgrey; text-align: center;'>None</div>";
              }
              ?>
            </div>
          </div>
          <div class="four wide column">
            <h5 class="ui header center aligned">Tools</h5>
            <div class="ui celled list">
              <?php
              if ($tools != null) {
                foreach ($tools as $res) {
              ?>
                  <div class="item">
                    <div class="content">
                      <?php echo stripslashes($res); ?>
                    </div>
                  </div>
              <?php
                }
              } else {
                echo "<div style='color:lightgrey; text-align: center;'>None</div>";
              }

              ?>
            </div>
          </div>
        </div>
      </div>

    </div>

  <?php
  }
} elseif (isset($_POST["getEditValues"])) {
  $tna_id = $_POST["tna_id"];

  $sql = "SELECT * FROM `tna` WHERE `tna_id` = '$tna_id'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  $department_id = $row["department_id"];
  $manager_trs = unserialize($row["manager_trs"]);
  $staff_trs = unserialize($row["staff_trs"]);
  $all_trs = unserialize($row["all_trs"]);
  $tools = unserialize($row["tools"]);

  $manager_arr = array();
  $staff_arr = array();
  $all_arr = array();
  $tools_arr = array();

  foreach ($manager_trs as $training_id) {
    $sql = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $training = $row["training"];
    array_push($manager_arr, $training);
  }

  foreach ($staff_trs as $training_id) {
    $sql = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $training = $row["training"];
    array_push($staff_arr, $training);
  }

  foreach ($all_trs as $training_id) {
    $sql = "SELECT `training` FROM `trainings` WHERE `training_id` = '$training_id'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $training = $row["training"];
    array_push($all_arr, $training);
  }

  foreach ($tools as $tool) {
    array_push($tools_arr, stripslashes($tool));
  }

  $json = array(
    'department_id' => $department_id,
    'manager_arr' => $manager_arr,
    'staff_arr' => $staff_arr,
    'all_arr' => $all_arr,
    'tools' => $tools_arr
  );

  echo json_encode($json);
} elseif (isset($_POST["edit"])) {
  $tna_id = $_POST["tna_id"];
  $department_id = $_POST["department_id"];
  $manager_arr = $_POST["manager_arr_edit"];
  $staff_arr = $_POST["staff_arr_edit"];
  $all_arr = $_POST["all_arr_edit"];
  $tools_arr = $_POST["tools_arr_edit"];


  $manager_arr_sql = array();
  $staff_arr_sql = array();
  $all_arr_sql = array();
  $tools_arr_sql = array();

  foreach ($manager_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($manager_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($manager_arr_sql, $training_id);
    }
  }

  foreach ($staff_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($staff_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($staff_arr_sql, $training_id);
    }
  }

  foreach ($all_arr as $training) {
    $sql = "SELECT `training_id` FROM `trainings` WHERE `training` = '$training'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $training = addslashes($training);
      $sql1 = "INSERT INTO `trainings` (`training`, `dateAdded`) VALUES ('$training', '$currentDate')";
      $mysqli->query($sql1);
      $training_id = $mysqli->insert_id;
      array_push($all_arr_sql, $training_id);
    } else {
      $row = $result->fetch_assoc();
      $training_id = $row["training_id"];
      array_push($all_arr_sql, $training_id);
    }
  }

  foreach ($tools_arr as $tool) {
    array_push($tools_arr_sql, addslashes($tool));
  }

  $manager_arr_sql = serialize($manager_arr_sql);
  $staff_arr_sql = serialize($staff_arr_sql);
  $all_arr_sql = serialize($all_arr_sql);
  $tools_arr_sql = addslashes(serialize($tools_arr_sql));

  $sql = "UPDATE `tna` SET `department_id`='$department_id',`manager_trs`='$manager_arr_sql',`staff_trs`='$staff_arr_sql',`all_trs`='$all_arr_sql',`tools`='$tools_arr_sql' WHERE `tna_id` = '$tna_id'";
  $mysqli->query($sql);
} elseif (isset($_POST["populate_findDeptDrop"])) {
  $sql = "SELECT * FROM `department` WHERE `department_id` IN (SELECT `department_id` FROM `tna`)";
  $result = $mysqli->query($sql);
  ?>

  <option value="all">All</option>

  <?php
  while ($row = $result->fetch_assoc()) {
    $department_id = $row["department_id"];
    $department = $row["department"];
  ?>

    <option value="<?php echo $department_id; ?>"><?php echo $department; ?></option>

    <?php

  }
} 
elseif (isset($_POST["search_by_training"])) {

  $keyword = $_POST["keyword"];
  $tnaIDS = getTNAuniqueIDs($mysqli);
// echo implode(',', $tnaIDS);

// " . implode(',', $tnaIDS) . "
  $sql = "SELECT * FROM `trainings` WHERE `training_id` IN (" . implode(',', $tnaIDS) . ") AND `training` LIKE '%$keyword%'";

  // $sql = "SELECT * FROM table WHERE comp_id IN (" . implode(',', $arr) . ")";

  $result = $mysqli->query($sql);
  $num_results = $result->num_rows;
  // if found multiple results
  if ($num_results > 0) {

    if ($num_results > 1) {
      echo "<div style=\"color: grey;\">Search Results: Found $num_results trainings with keyword [$keyword]</div><br>";
    } elseif ($num_results == 1) {
      echo "<div style=\"color: grey;\">Search Results: Found $num_results training with keyword [$keyword]</div><br>";
    }

    echo "<div class=\"ui styled fluid accordion tp\">";

    while ($row = $result->fetch_assoc()) {
      $training_id = $row["training_id"];
      $training = $row["training"];
    ?>


      <div class="title">
        <i class="dropdown icon"></i>
        <?php echo $training; ?>
      </div>
      <div class="content">
        <p class="transition hidden">
          <?php
          $sql1 = "SELECT * FROM `tna`";
          $result1 = $mysqli->query($sql1);
          $num_results = $result1->num_rows;
          $none_counter = 0;
          while ($row1 = $result1->fetch_assoc()) {
            $department_id = $row1["department_id"];
            $manager_trs = unserialize($row1["manager_trs"]);
            $staff_trs = unserialize($row1["staff_trs"]);
            $all_trs = unserialize($row1["all_trs"]);
            $tools = unserialize($row1["tools"]);
            if (in_array($training_id, $manager_trs) or in_array($training_id, $staff_trs) or in_array($training_id, $all_trs)) {
          ?>
        <div class="ui blue basic segment">

          <h5 class="ui blue header block top attached">
            <?php
              $sql2 = "SELECT `department` FROM `department` WHERE `department_id` = '$department_id'";
              $result2 = $mysqli->query($sql2);
              $row2 = $result2->fetch_assoc();
              echo $department = $row2["department"];
            ?>
          </h5>

          <div class="ui segment buttom attached">
            <div class="ui grid">
              <div class="four wide column">
                <h5 class="ui header center aligned">Manager</h5>
                <div class="ui celled list">
                  <?php

                  if (in_array($training_id, $manager_trs)) {
                    $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` = 'SUPERVISORY' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
                    $result3 = $mysqli->query($sql3);
                    while ($row3 = $result3->fetch_assoc()) {
                      $firstName = $row3["firstName"];
                      $middleName = $row3["middleName"];
                      $lastName = $row3["lastName"];
                      $extName = $row3["extName"];

                      $employee_fullName = "$lastName, $firstName $middleName $extName";
                      echo "<div class=\"item\">$employee_fullName</div>";
                    }
                  } else {
                    echo "<div class=\"item\" style=\"color: lightgrey;\">N/A</div>";
                  }

                  ?>
                </div>
              </div>
              <div class="four wide column">
                <h5 class="ui header center aligned">Staff</h5>

                <div class="ui celled list">
                  <?php

                  if (in_array($training_id, $staff_trs)) {
                    $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` = 'RANK & FILE' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
                    $result3 = $mysqli->query($sql3);
                    while ($row3 = $result3->fetch_assoc()) {
                      $firstName = $row3["firstName"];
                      $middleName = $row3["middleName"];
                      $lastName = $row3["lastName"];
                      $extName = $row3["extName"];

                      $employee_fullName = "$lastName, $firstName $middleName $extName";
                      echo "<div class=\"item\">$employee_fullName</div>";
                    }
                  } else {
                    echo "<div class=\"item\" style=\"color: lightgrey;\">N/A</div>";
                  }

                  ?>
                </div>

              </div>
              <div class="four wide column">
                <h5 class="ui header center aligned">All</h5>

                <div class="ui celled list">
                  <?php

                  if (in_array($training_id, $all_trs)) {
                    $sql3 = "SELECT * FROM `employees` WHERE `department_id` = '$department_id' AND `status`='ACTIVE' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
                    $result3 = $mysqli->query($sql3);
                    while ($row3 = $result3->fetch_assoc()) {
                      $firstName = $row3["firstName"];
                      $middleName = $row3["middleName"];
                      $lastName = $row3["lastName"];
                      $extName = $row3["extName"];

                      $employee_fullName = "$lastName, $firstName $middleName $extName";
                      echo "<div class=\"item\">$employee_fullName</div>";
                    }
                  } else {
                    echo "<div class=\"item\" style=\"color: lightgrey;\">N/A</div>";
                  }

                  ?>
                </div>

              </div>
              <div class="four wide column">
                <h5 class="ui header center aligned">Tools</h5>


                <div class="ui celled list">
                  <?php

                  if (!empty($tools)) {

                    foreach ($tools as $tool) {
                      echo "<div class=\"item\">" . strtoupper(stripslashes($tool)) . "</div>";
                    }
                  } else {
                    echo "<div class=\"item\" style=\"color: lightgrey;\">N/A</div>";
                  }

                  ?>
                </div>


              </div>

            </div>
          </div>
        </div>
    <?php
            } else {
              $none_counter++;
            }
          }

          if ($none_counter == $num_results) {
            echo "<div class=\"ui basic blue segment\" style=\"color: lightgrey;\">None</div>";
          }



    ?>
    </p>
      </div>



<?php
    }
    echo "</div>";
  }
  // if found single results
  // elseif ($num_results == 1) {
  //   echo "<div>Search Results: Found $num_results training with keyword [$keyword]</div>";
  // } 
  // if found none
  else {
    echo "<div>No training with keyword [$keyword] was found!</div>";
  }
}
elseif (isset($_POST["getConsolidatedTNA"])) {
  $data = [];
  $tnas = getTNAdata($mysqli);
  $trainings = getTrainings($mysqli);

  foreach ($trainings as $training) {
    $departments = array();
    $countDepartments = 0;
    $training_id = $training["training_id"];


    foreach ($tnas as $tna) {
      $department_id = $tna["department_id"];
      $department = $tna["department"];
      $training_ids = $tna["training_ids"];

      foreach ($training_ids as $tr_id) {
        if ($tr_id == $training_id) {
          $departments[] = array(
            "department_id" => $department_id,
            "department" => $department,
          );
          $countDepartments += 1;
          break;
        }
      }
    }

    $datum = array(
      "training_id" => $training_id,
      "training" => $training["training"],
      "countDepartments" => $countDepartments,
      "departments" => $departments
    );

    array_push($data, $datum);
  }

  usort($data, "sortArrayDesc");

  echo json_encode($data);
} elseif (isset($_POST["getTargetParticipants"])) {

  $training_id = $_POST["training_id"];
  $departments = isset($_POST["departments"])?$_POST["departments"]:[];
  $data = [];

  // if (count($departments)==0) return $data;

  foreach ($departments as $dept) {

    $department_id = $dept["department_id"];
    $department = $dept["department"];

    $managers = [];
    $staffs = [];
    $all = [];



    $haveManagerTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["manager_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveManagerTraining = true;
          break;
        }
      }
    }



    $haveStaffTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["staff_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveStaffTraining = true;
          break;
        }
      }
    }


    $haveAllTraining = false;
    $sql = "SELECT * FROM `tna` WHERE `department_id` = '$department_id'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
      $trs = unserialize($row["all_trs"]);
      foreach ($trs as $tr) {
        if ($tr == $training_id) {
          $haveAllTraining = true;
          break;
        }
      }
    }

  if ($haveManagerTraining && $haveStaffTraining) {
    $haveAllTraining = true;
  }



    if ($haveManagerTraining && $haveAllTraining != true) {
      $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` = 'SUPERVISORY' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];
        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $managers[] = $employee_fullName;
      }
    }



    if ($haveStaffTraining && $haveAllTraining != true) {
      $sql3 = "SELECT * FROM `employees` WHERE `natureOfAssignment` != 'SUPERVISORY' AND `status`='ACTIVE' AND `department_id` = '$department_id' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];

        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $staffs[] = $employee_fullName;
      }
    }



    // haveManagerTraining
    // haveStaffTraining
    // haveAllTraining
    if ($haveAllTraining || $haveManagerTraining && $haveStaffTraining) {
      $sql3 = "SELECT * FROM `employees` WHERE `department_id` = '$department_id' AND `status`='ACTIVE' AND `employees_id` NOT IN (SELECT `employees_id` FROM `personneltrainingslist` WHERE `personneltrainings_id` IN (SELECT `personneltrainings_id` FROM `personneltrainings` WHERE `training_id` = '$training_id'))";
      $result3 = $mysqli->query($sql3);
      while ($row3 = $result3->fetch_assoc()) {
        $firstName = $row3["firstName"];
        $middleName = $row3["middleName"];
        $lastName = $row3["lastName"];
        $extName = $row3["extName"];

        $employee_fullName = "$lastName, $firstName $middleName $extName";
        $all[] = $employee_fullName;
      }
    }

    $datum = [
      "department" => $department,
      "managers" => $managers,
      "staffs" => $staffs,
      "all" => $all
    ];

    array_push($data, $datum);
  }


  echo json_encode($data);
}





function getDepartmentsWithTraining($mysqli, $training_id)
{
  $departments = array();



  return $departments;
}


function getTrainings($mysqli)
{

  $data = [];
  $sql = "SELECT * FROM `trainings` ORDER BY `trainings`.`training_id` ASC";
  $result = $mysqli->query($sql);

  while ($row = $result->fetch_assoc()) {
    $training_id = $row["training_id"];
    $training = $row["training"];
    $datum = array(
      "training_id" => $training_id,
      "training" => $training
    );
    array_push($data, $datum);
  }

  return $data;
}


function getTNAdata($mysqli)
{
  $data = [];
  $sql = "SELECT `tna`.*, `department`.`department` FROM `tna` LEFT JOIN `department` ON `tna`.`department_id` = `department`.`department_id`";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $training_ids = unserialize($row["all_trs"]);
    $training_ids_manager = unserialize($row["manager_trs"]);
    $training_ids_staff = unserialize($row["staff_trs"]);

    $training_ids_merged = array_merge($training_ids, $training_ids_manager, $training_ids_staff);
    $department_id = $row["department_id"];
    $department = $row["department"];
    $datum = array(
      "department_id" => $department_id,
      // "training_ids" => $training_ids,
      // "training_ids_manager" => $training_ids_manager,
      // "training_ids_staff" => $training_ids_staff,
      "training_ids" => $training_ids_merged,
      "department" => $department
    );
    array_push($data, $datum);
  }
  return $data;
}

function sortArrayDesc($a, $b)
{
  return $b["countDepartments"] <=> $a["countDepartments"];
}


function getTNAuniqueIDs($mysqli)
{
    $data = [];
    $sql = "SELECT `tna`.*, `department`.`department` FROM `tna` LEFT JOIN `department` ON `tna`.`department_id` = `department`.`department_id`";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $training_ids = unserialize($row["all_trs"]);
        $training_ids_manager = unserialize($row["manager_trs"]);
        $training_ids_staff = unserialize($row["staff_trs"]);
        $training_ids_merged = array_merge($training_ids, $training_ids_manager, $training_ids_staff);
        array_push($data, $training_ids_merged);
    }
    $merged_array = [];
    foreach ($data as $dat) {
        $merged_array = array_merge($merged_array, $dat);
    }
    return array_values(array_unique($merged_array));
}

?>