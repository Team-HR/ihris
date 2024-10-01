<?php
require_once '../_connect.db.php';

if (isset($_GET['getPdsPersonal'])) {
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT `id` FROM `pds_personal` WHERE `pds_personal`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();

    if ($num_rows == 0) {
        $sql = "INSERT INTO `pds_personal` (`employee_id`) VALUES (?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $stmt->close();
    }

    $sql = "SELECT `employees`.`lastName`,`employees`.`firstName`,`employees`.`middleName`,`employees`.`extName`,`pds_personal`.* FROM `employees` LEFT JOIN `pds_personal` ON `employees`.`employees_id` = `pds_personal`.`employee_id` WHERE `employees`.`employees_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    echo json_encode($data);
} elseif (isset($_GET['getPdsFamily'])) {
    $employee_id = $_GET['employee_id'];
    $data = [];
    $sql = "SELECT `id` FROM `pds_families` WHERE `pds_families`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();

    if ($num_rows == 0) {
        $sql = "INSERT INTO `pds_families` (`employee_id`) VALUES (?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $stmt->close();
    }

    $sql = "SELECT `pds_families`.* FROM `pds_families` WHERE `pds_families`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();

    $data['children'] = [];
    $sql = "SELECT `pds_children`.`child_name`,`pds_children`.`child_birthdate` FROM `pds_children` WHERE `pds_children`.`employee_id` = ?";
    // $employee_id = 2158;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data['children'][] = $row;
    }
    $stmt->close();


    echo json_encode($data);
} elseif (isset($_GET['getPdsEducation'])) {
    $employee_id = $_GET['employee_id'];

    $data = array(
        "elementary" => array(),
        "secondary" => array(),
        "vocational" => array(),
        "college" => array(),
        "graduate_studies" => array()
    );

    $sql = "SELECT * FROM `pds_educations` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $school = array(
            "school" => $row["school"],
            "degree_course" => $row["degree_course"],
            "ed_period" => $row["ed_period"],
            "year_graduated" => $row["year_graduated"],
            "grade_level_units" => $row["grade_level_units"],
            "scholarships_honors" => $row["scholarships_honors"]
        );
        $data[$row["ed_level"]][] = $school;
    }

    echo json_encode($data);
} elseif (isset($_GET['getPdsEligibility'])) {
    $employee_id = $_GET['employee_id'];
    $data = array();

    $sql = "SELECT * FROM `pds_eligibilities` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $datum = array(
            "elig_title" => $row["elig_title"],
            "rating" => $row["rating"],
            "exam_date" => $row["exam_date"],
            "exam_place" => $row["exam_place"],
            "license_id" => $row["license_id"],
            "release_date" => $row["release_date"]
        );
        $data[] = $datum;
    }
    echo json_encode($data);
} elseif (isset($_GET['getPdsExperiences'])) {
    $employee_id = $_GET['employee_id'];
    $data = array();

    $sql = "SELECT * FROM `pds_experiences` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $datum = array(
            "exp_from" => $row["exp_from"],
            "exp_to" => $row["exp_to"],
            "exp_position" => $row["exp_position"],
            "exp_company" => $row["exp_company"],
            "exp_monthly_salary" => $row["exp_monthly_salary"],
            "exp_sg" => $row["exp_sg"],
            "exp_status_of_appointment" => $row["exp_status_of_appointment"],
            "exp_govt" => $row["exp_govt"]
        );
        $data[] = $datum;
    }
    echo json_encode($data);
} elseif (isset($_GET['getPdsVoluntaries'])) {
    $employee_id = $_GET['employee_id'];
    $data = array();

    $sql = "SELECT * FROM `pds_voluntaries` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $datum = array(
            "vw_organization" => $row["vw_organization"],
            "vw_from" => $row["vw_from"],
            "vw_to" => $row["vw_to"],
            "vw_hours" => $row["vw_hours"],
            "vw_nature_work" => $row["vw_nature_work"]
        );
        $data[] = $datum;
    }
    echo json_encode($data);
} elseif (isset($_GET['getPdsTrainings'])) {
    $employee_id = $_GET['employee_id'];
    $data = array();

    $sql = "SELECT * FROM `pds_trainings` WHERE `employee_id` = ? ORDER BY `tr_from` DESC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $datum = array(
            "tr_title" => $row["tr_title"],
            "tr_from" => $row["tr_from"],
            "tr_to" => $row["tr_to"],
            "tr_hours" => $row["tr_hours"],
            "tr_by" => $row["tr_by"]
        );
        $data[] = $datum;
    }
    echo json_encode($data);
} elseif (isset($_GET['getPdsOtherInformation'])) {
    $employee_id = $_GET['employee_id'];
    $data = array();

    $pds_hobbies_and_skills = array();
    $sql = "SELECT * FROM `pds_hobbies_and_skills` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pds_hobbies_and_skills[] = $row["hs_name"];
    }
    $stmt->close();

    $pds_non_academic_recognitions = array();
    $sql = "SELECT * FROM `pds_non_academic_recognitions` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pds_non_academic_recognitions[] = $row["nar_title"];
    }
    $stmt->close();

    $pds_org_memberships = array();
    $sql = "SELECT * FROM `pds_org_memberships` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pds_org_memberships[] = $row["org_name"];
    }
    $stmt->close();

    $pds_references = array();
    $sql = "SELECT * FROM `pds_references` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pds_reference = array(
            "ref_name" => $row["ref_name"],
            "ref_address" => $row["ref_address"],
            "ref_tel" => $row["ref_tel"]
        );
        $pds_references[] = $pds_reference;
    }
    $stmt->close();

    $pds_personal = array();
    $sql = "SELECT * FROM `pds_personal` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $pds_personal["third_degree"] = $row["third_degree"];
    $pds_personal["fourth_degree"] = $row["fourth_degree"];
    $pds_personal["degree_details"] = $row["degree_details"];
    $pds_personal["admin_offense"] = $row["admin_offense"];
    $pds_personal["admin_offense_details"] = $row["admin_offense_details"];
    $pds_personal["criminally_charged"] = $row["criminally_charged"];
    $pds_personal["case_date_filed"] = $row["case_date_filed"];
    $pds_personal["case_status"] = $row["case_status"];
    $pds_personal["convicted"] = $row["convicted"];
    $pds_personal["convicted_details"] = $row["convicted_details"];
    $pds_personal["separated_from_service"] = $row["separated_from_service"];
    $pds_personal["separated_from_service_details"] = $row["separated_from_service_details"];
    $pds_personal["election_candidate"] = $row["election_candidate"];
    $pds_personal["election_candidate_details"] = $row["election_candidate_details"];
    $pds_personal["resigned_gov_to_campaign"] = $row["resigned_gov_to_campaign"];
    $pds_personal["resigned_gov_to_campaign_details"] = $row["resigned_gov_to_campaign_details"];
    $pds_personal["immigrant"] = $row["immigrant"];
    $pds_personal["immigrant_details"] = $row["immigrant_details"];
    $pds_personal["indigenous_member"] = $row["indigenous_member"];
    $pds_personal["indigenous_member_details"] = $row["indigenous_member_details"];
    $pds_personal["pwd"] = $row["pwd"];
    $pds_personal["pwd_details"] = $row["pwd_details"];
    $pds_personal["solo_parent"] = $row["solo_parent"];
    $pds_personal["solo_parent_details"] = $row["solo_parent_details"];
    $stmt->close();

    $data[] = $pds_hobbies_and_skills;
    $data[] = $pds_non_academic_recognitions;
    $data[] = $pds_org_memberships;
    $data[] = $pds_references;
    $data[] = $pds_personal;
    echo json_encode($data);
} elseif (isset($_POST['save_pds_personal'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    // echo json_encode($data);
    array_walk($data, function (&$data1) {
        if ($data1 == "true" || $data1 == "false") {
            $data1 = $data1 == "true" ? 1 : 0;
        } else {
            $data1 = !empty($data1) ? $data1 : null;
        }
    });

    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;


    $sql = "UPDATE `pds_personal` SET `third_degree`=?,`fourth_degree`=?,`degree_details`=?,`admin_offense`=?,`admin_offense_details`=?,`criminally_charged`=?,`case_date_filed`=?,`case_status`=?,`convicted`=?,`convicted_details`=?,`separated_from_service`=?,`separated_from_service_details`=?,`election_candidate`=?,`election_candidate_details`=?,`resigned_gov_to_campaign`=?,`resigned_gov_to_campaign_details`=?,`immigrant`=?,`immigrant_details`=?,`indigenous_member`=?,`indigenous_member_details`=?,`pwd`=?,`pwd_details`=?,`solo_parent`=?,`solo_parent_details`=? WHERE `employee_id` = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iisisissisisisisisisisisi", $data["third_degree"], $data["fourth_degree"], $data["degree_details"], $data["admin_offense"], $data["admin_offense_details"], $data["criminally_charged"], $data["case_date_filed"], $data["case_status"], $data["convicted"], $data["convicted_details"], $data["separated_from_service"], $data["separated_from_service_details"], $data["election_candidate"], $data["election_candidate_details"], $data["resigned_gov_to_campaign"], $data["resigned_gov_to_campaign_details"], $data["immigrant"], $data["immigrant_details"], $data["indigenous_member"], $data["indigenous_member_details"], $data["pwd"], $data["pwd_details"], $data["solo_parent"], $data["solo_parent_details"], $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    echo json_encode($affected_rows);
} elseif (isset($_POST['save_pds_references'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];

    array_walk($data, function (&$data1) {
        array_walk($data1, function (&$item1) {
            $item1 = !empty($item1) ? $item1 : null;
        });
    });

    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_references` WHERE `pds_references`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            $countNull = 0;
            foreach ($datum as $key => $value) {
                if (empty($value)) $countNull++;
            }
            if ($countNull == 3) continue;
            $sql = "INSERT INTO `pds_references` (`employee_id`,`ref_name`,`ref_address`,`ref_tel`) VALUES (?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("isss", $employee_id, $datum["ref_name"], $datum["ref_address"], $datum["ref_tel"]);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['save_pds_org_memberships'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_org_memberships` WHERE `pds_org_memberships`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            if (empty($datum)) continue;
            $sql = "INSERT INTO `pds_org_memberships` (`employee_id`,`org_name`) VALUES (?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $employee_id, $datum);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['save_pds_non_academic_recognitions'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_non_academic_recognitions` WHERE `pds_non_academic_recognitions`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            if (empty($datum)) continue;
            $sql = "INSERT INTO `pds_non_academic_recognitions` (`employee_id`,`nar_title`) VALUES (?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $employee_id, $datum);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['save_pds_hobbies_and_skills'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_hobbies_and_skills` WHERE `pds_hobbies_and_skills`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            if (empty($datum)) continue;
            $sql = "INSERT INTO `pds_hobbies_and_skills` (`employee_id`,`hs_name`) VALUES (?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("is", $employee_id, $datum);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsTrainings'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    // echo json_encode($data);
    // nullifier
    array_walk($data, function (&$data1) {
        array_walk($data1, function (&$item1) {
            if ($item1 == "0000-00-00") {
                $item1  = null;
            }
            $item1 = !empty($item1) ? $item1 : null;
        });
    });
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_trainings` WHERE `pds_trainings`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            $countNull = 0;
            foreach ($datum as $key => $value) {
                if (empty($value)) $countNull++;
                elseif ($value == "0000-00-00") {
                    $countNull++;
                }
            }
            if ($countNull == 5) continue;
            $sql = "INSERT INTO `pds_trainings` (`employee_id`,`tr_title`,`tr_from`,`tr_to`,`tr_hours`,`tr_by`) VALUES (?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("isssds", $employee_id, $datum["tr_title"], $datum["tr_from"], $datum["tr_to"], $datum["tr_hours"], $datum["tr_by"]);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsVoluntaries'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    // echo json_encode($data);
    // nullifier
    array_walk($data, function (&$data1) {
        array_walk($data1, function (&$item1) {
            $item1 = $item1 ? $item1 : null;
        });
    });
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_voluntaries` WHERE `pds_voluntaries`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            $countNull = 0;
            foreach ($datum as $key => $value) {
                if (empty($value)) $countNull++;
                elseif ($value == "0000-00-00") {
                    $countNull++;
                }
            }
            if ($countNull == 5) continue;
            $sql = "INSERT INTO `pds_voluntaries` (`employee_id`,`vw_organization`,`vw_from`,`vw_to`,`vw_hours`,`vw_nature_work`) VALUES (?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("isssds", $employee_id, $datum["vw_organization"], $datum["vw_from"], $datum["vw_to"], $datum["vw_hours"], $datum["vw_nature_work"]);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsExperiences'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    // nullifier
    array_walk($data, function (&$data1) {
        array_walk($data1, function (&$item1) {
            $item1 = $item1 ? $item1 : null;
        });
    });
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_experiences` WHERE `pds_experiences`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            $countNull = 0;
            foreach ($datum as $key => $value) {
                if (empty($value)) $countNull++;
                elseif ($value == "0000-00-00") {
                    $countNull++;
                }
            }
            if ($countNull == 8) continue;
            $sql = "INSERT INTO `pds_experiences` (
                `employee_id`,`exp_from`,`exp_to`,`exp_position`,`exp_company`,`exp_monthly_salary`,`exp_sg`,`exp_status_of_appointment`,`exp_govt`) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("issssssss", $employee_id, $datum["exp_from"], $datum["exp_to"], $datum["exp_position"], $datum["exp_company"], $datum["exp_monthly_salary"], $datum["exp_sg"], $datum["exp_status_of_appointment"], $datum["exp_govt"]);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsEligibility'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    // nullifier
    array_walk($data, function (&$data1) {
        array_walk($data1, function (&$item1) {
            $item1 = $item1 ? $item1 : null;
        });
    });
    $employee_id = $_POST["employee_id"];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_eligibilities` WHERE `pds_eligibilities`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($data) > 0) {
        foreach ($data as $datum) {
            $countNull = 0;
            foreach ($datum as $key => $value) {
                if (empty($value)) $countNull++;
                elseif ($value == "0000-00-00") {
                    $countNull++;
                }
            }
            if ($countNull == 6) continue;
            $sql = "INSERT INTO `pds_eligibilities` (`employee_id`,`elig_title`,`rating`,`exam_date`,`exam_place`,`license_id`,`release_date`) VALUES (?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param(
                "issssss",
                $employee_id,
                $datum["elig_title"],
                $datum["rating"],
                $datum["exam_date"],
                $datum["exam_place"],
                $datum["license_id"],
                $datum["release_date"]
            );
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsEducation'])) {

    $data = isset($_POST['data']) ? $_POST['data'] : [];
    $employee_id = $_POST['employee_id'];

    $affected_rows = 0;

    $sql = "DELETE FROM `pds_educations` WHERE `pds_educations`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();


    foreach ($data as $ed_level => $schools) {
        foreach ($schools as $school) {
            $countNull = 0;
            foreach ($school as $key => $value) {
                if (empty($value)) $countNull++;
            }
            if ($countNull == 6) continue;
            $sql = "INSERT INTO `pds_educations` (`employee_id`, `ed_level`, `school`, `degree_course`, `ed_period`, `year_graduated`, `grade_level_units`, `scholarships_honors`) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("issssiss", $employee_id, $ed_level, $school['school'], $school['degree_course'], $school['ed_period'], $school['year_graduated'], $school['grade_level_units'], $school['scholarships_honors']);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }

    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsFamily'])) {
    $employee = $_POST['employee'];
    // echo json_encode($employee);
    // print_r($employee);
    array_walk($employee, function (&$item1, $key) {
        if ($key == "children") {
            if (count($item1) > 0) {
                foreach ($item1 as $index => $child) {
                    if ($child["child_name"] == "" && $child["child_birthdate"] == "") {
                        unset($item1[$index]);
                    }
                }
            }
        } else {
            $item1 = $item1 ? $item1 : null;
        }
    });

    $children = [];
    $children = isset($employee["children"]) ? $employee["children"] : [];

    $affected_rows = 0;

    $sql = "UPDATE `pds_families` SET `father_ext_name` = ?,`father_first_name` = ?,`father_last_name` = ?,`father_middle_name` = ?,`mother_first_name` = ?,`mother_last_name` = ?,`mother_middle_name` = ?,`spouse_business_address` = ?,`spouse_employeer` = ?,`spouse_ext_name` = ?,`spouse_first_name` = ?,`spouse_last_name` = ?,`spouse_middle_name` = ?,`spouse_mobile` = ?,`spouse_occupation` = ? WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssssssssssi", $employee['father_ext_name'], $employee['father_first_name'], $employee['father_last_name'], $employee['father_middle_name'], $employee['mother_first_name'], $employee['mother_last_name'], $employee['mother_middle_name'], $employee['spouse_business_address'], $employee['spouse_employeer'], $employee['spouse_ext_name'], $employee['spouse_first_name'], $employee['spouse_last_name'], $employee['spouse_middle_name'], $employee['spouse_mobile'], $employee['spouse_occupation'], $employee['employee_id']);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();


    $sql = "DELETE FROM `pds_children` WHERE `pds_children`.`employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $employee["employee_id"]);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    if (count($children) > 0) {
        foreach ($children as $child) {
            $sql = "INSERT INTO `pds_children` (`employee_id`, `child_name`, `child_birthdate`) VALUES (?,?,?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iss", $employee["employee_id"], $child["child_name"], $child["child_birthdate"]);
            $stmt->execute();
            $affected_rows += $stmt->affected_rows;
            $stmt->close();
        }
    }
    echo json_encode($affected_rows);
} elseif (isset($_POST['savePdsPersonal'])) {
    $employee = $_POST['employee'];

    // echo json_encode($employee);
    // return null;

    array_walk($employee, function (&$item1) {
        if ($item1 == "true" || $item1 == "false") {
            $item1 = $item1 == "true" ? 1 : 0;
        } else
            $item1 = $item1 ? $item1 : null;
    });

    $affected_rows = 0;

    $employee["lastName"] = strtoupper($employee["lastName"]);
    $employee["firstName"] = strtoupper($employee["firstName"]);
    $employee["middleName"] = $employee["middleName"] && $employee["middleName"] != "." && $employee["middleName"] != 'N/A' && $employee["middleName"] != 'n/a' ? strtoupper($employee["middleName"]) : NULL;
    $employee["extName"] = $employee["extName"] && $employee["extName"] != "." && $employee["extName"] != 'N/A' && $employee["extName"] != 'n/a'? strtoupper($employee["extName"]) : NULL;

    $sql = "UPDATE `employees` SET `lastName` = ?, `firstName` = ?, `middleName` = ?, `extName` = ? WHERE `employees_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi", $employee["lastName"], $employee["firstName"], $employee["middleName"], $employee["extName"], $employee["employee_id"]);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();

    $sql = "UPDATE `pds_personal` SET `birthdate` = ?,`birthplace` = ?,`citizenship` = ?,`gender` = ?,`civil_status` = ?,`height` = ?,`weight` = ?,`blood_type` = ?,`gsis_id` = ?,`pag_ibig_id` = ?,`philhealth_id` = ?,`sss_id` = ?,`tin_id` = ?,`res_house_no` = ?,`res_street` = ?,`res_subdivision` = ?,`res_barangay` = ?,`res_city` = ?,`res_province` = ?,`res_zip_code` = ?,`res_tel` = ?,`permadd_resadd_same`=?,`perm_house_no` = ?,`perm_street` = ?,`perm_subdivision` = ?,`perm_barangay` = ?,`perm_city` = ?,`perm_province` = ?,`perm_zip_code` = ?,`perm_tel` = ?,`mobile` = ?,`email` = ?, `emergency_name` = ?, `emergency_number` = ?, `emergency_address` = ? WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssisssssssssssssi", $employee['birthdate'], $employee['birthplace'], $employee['citizenship'], $employee['gender'], $employee['civil_status'], $employee['height'], $employee['weight'], $employee['blood_type'], $employee['gsis_id'], $employee['pag_ibig_id'], $employee['philhealth_id'], $employee['sss_id'], $employee['tin_id'], $employee['res_house_no'], $employee['res_street'], $employee['res_subdivision'], $employee['res_barangay'], $employee['res_city'], $employee['res_province'], $employee['res_zip_code'], $employee['res_tel'], $employee["permadd_resadd_same"], $employee['perm_house_no'], $employee['perm_street'], $employee['perm_subdivision'], $employee['perm_barangay'], $employee['perm_city'], $employee['perm_province'], $employee['perm_zip_code'], $employee['perm_tel'], $employee['mobile'], $employee['email'], $employee['emergency_name'], $employee['emergency_number'], $employee['emergency_address'], $employee['employee_id']);
    $stmt->execute();
    $affected_rows += $stmt->affected_rows;
    $stmt->close();
    echo json_encode($affected_rows);
}
