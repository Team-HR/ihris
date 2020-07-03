<?php

require "_connect.db.php";

if(isset($_POST["getData"])){
    
    $sql = "SELECT
    -- *
    positiontitles.position,
    positiontitles.functional,
    plantillas.item_no,
    plantillas.sg,
    -- 	plantillas.actual_salary,
    ( plantillas.actual_salary / 12 ) AS monthly_salary,
    qualification_standards.education,
    qualification_standards.experience,
    qualification_standards.training,
    qualification_standards.eligibility,
    qualification_standards.competency,
    qualification_standards.others,
    department.department 
    FROM
        plantillas
        LEFT JOIN positiontitles ON plantillas.position_id = positiontitles.position_id
        LEFT JOIN qualification_standards ON qualification_standards.position_id = positiontitles.position_id
        LEFT JOIN department ON plantillas.department_id = department.department_id 
    WHERE
        plantillas.incumbent IS NULL 
    ORDER BY
        positiontitles.position ASC";
    
    // $data = $test;
    
    $result = $mysqli->query($sql);
    while($row = $result->fetch_assoc())
    {
        $data[] = array(
            "position_title"=>$row["position"],
            "item_no"=>$row["item_no"],
            "sg"=>$row["sg"],
            "monthly_salary"=>$row["monthly_salary"],
            "education"=>$row["education"],
            "training"=>$row["training"],
            "experience"=>$row["experience"],
            "eligibility"=>$row["eligibility"],
            "competency"=>$row["competency"],
            "department"=>$row["department"]
        );
    }

    echo json_encode($data);

}