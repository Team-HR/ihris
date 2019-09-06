<?php 
require_once "_connect.db.php";

if (isset($_POST["addNew"])) {

  $data = $_POST["data"];
  $type = $_POST["type"];
  $rspvac_id = $_POST["rspvac_id"];
  // $training = serialize($data[10]["Training"]);
  // $experience = serialize($data[11]);
  // $eligibility = serialize($data[10][$data[10][1]]);
  // $awards = serialize($data[10][$data[10][2]]);
  // $records = serialize($data[10][$data[10][3]]);

  $sql = "INSERT INTO `rsp_applicants` (`applicant_id`, `name`, `age`, `gender`, `civil_status`, `mobile_no`, `address`, `education`, `school`, `training`, `num_years_in_gov`, `experience`, `eligibility`, `awards`, `records_infractions`, `remarks`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("sisssssssssssss",
        $data[0],
        $data[1],
        $data[2],
        $data[3],
        $data[4],
        $data[5],
        $data[6],
        $data[7],
        serialize($data[9]),
        serialize($data[13]),
        serialize($data[14]),
        serialize($data[10]),
        serialize($data[11]),
        serialize($data[12]),
        $data[8],
);
  $stmt->execute();
  $applicant_id = $stmt->insert_id;
  $stmt->close();


if ($type === "comparative") {
  # code...
  $sql = "INSERT INTO `rsp_comparative` (`rspcomp_id`, `rspvac_id`, `applicant_id`) VALUES (NULL, ?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ii",$rspvac_id,$applicant_id);
  $stmt->execute();
  $stmt->close();
}


} elseif (isset($_POST["editApplicant"])) {
  $data = $_POST["data"];
  $applicant_id = $_POST["applicant_id"];

  $sql = "UPDATE `rsp_applicants` SET `name`=?,`age`=?,`gender`=?,`civil_status`=?,`mobile_no`=?,`address`=?,`education`=?,`school`=?,`training`=?,`num_years_in_gov`=?,`experience`=?,`eligibility`=?,`awards`=?,`records_infractions`=?,`remarks`=? WHERE `applicant_id`=?";

  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("sisssssssssssssi",
        $data[0],
        $data[1],
        $data[2],
        $data[3],
        $data[4],
        $data[5],
        $data[6],
        $data[7],
        serialize($data[9]),
        serialize($data[13]),
        serialize($data[14]),
        serialize($data[10]),
        serialize($data[11]),
        serialize($data[12]),
        $data[8],
        $applicant_id
);
  $stmt->execute();
  $stmt->close();

}

 elseif (isset($_POST["getApplicantData"])) {
  $applicant_id = $_POST["applicant_id"];
// $applicant_id = 1;
  $sql = "SELECT * FROM `rsp_applicants` WHERE `applicant_id` = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i",$applicant_id);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result(
    $applicant_id,
    $name,
    $age,
    $gender,
    $civil_status,
    $mobile_no,
    $address,
    $education,
    $school,
    $training,
    $num_years_in_gov,
    $experience,
    $eligibility,
    $awards,
    $records_infractions,
    $remarks
  );
  $stmt->fetch();







  $json = array(
     $name,
     $age,
     $gender,
     $civil_status,
     $mobile_no,
     $address,
     $education,
     $school,
     arrayChecker($training),
     arrayChecker($num_years_in_gov),
     arrayChecker($experience),
     arrayChecker($eligibility),
     arrayChecker($awards),
     arrayChecker($records_infractions),
     $remarks
  );

  echo json_encode($json);
} elseif (isset($_POST["getApplicants"])) {
  
  $sql = "SELECT `applicant_id`,`name` FROM `rsp_applicants` ORDER BY `name` ASC";
  $stmt = $mysqli->prepare($sql);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($applicant_id,$name);
  
  $json = array();
  while ($stmt->fetch()) {
    $inside_json = array('title' => $name, 'id' => $applicant_id);
    array_push($json, $inside_json);
  }
  // 
  echo json_encode($json);
}

elseif (isset($_POST["addExistingApplicant"])) {
    
    $applicant_id = $_POST["applicant_id"];
    $rspvac_id = $_POST["rspvac_id"];
    
    $sql = "SELECT `rspcomp_id` FROM `rsp_comparative` WHERE `rspvac_id` = ? AND `applicant_id` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii",$rspvac_id,$applicant_id);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();

    if ($num_rows === 0) {
      $sql = "INSERT INTO `rsp_comparative` (`rspcomp_id`, `rspvac_id`, `applicant_id`) VALUES (NULL, ?, ?)";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("ii",$rspvac_id,$applicant_id);
      $stmt->execute();
      $stmt->close();
    }
    
} 


function arrayChecker($arr){
  $arr0 = [];
  $array = unserialize($arr);
  if ($array) {
    $arr0 = $array;
  }
  return $arr0;
}