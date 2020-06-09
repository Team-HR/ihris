<?php
 require '_connect.db.php';
 $employee_id = 2158;


    $schools = array(
        "elementary"=>array(),
        "secondary"=>array(),
        "vocational"=>array(),
        "college"=>array(),
        "graduate_studies"=>array()
    );
    
    $sql = "SELECT * FROM `pds_educations` WHERE `employee_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $school = array(
            "school" => $row["school"],
            "degree_course" => $row["degree_course"],
            "year_graduated" => $row["year_graduated"],
            "grade_level_units" => $row["grade_level_units"],
            "ed_from" => $row["ed_from"],
            "ed_to" => $row["ed_to"],
            "scholarships_honors" => $row["scholarships_honors"]
        );

        $schools[$row["ed_level"]][]=$school;
    }

    // echo json_encode($schools);

echo "<pre>".print_r($schools,true)."</pre>";