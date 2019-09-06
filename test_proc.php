<?php 
require_once "_connect.db.php";

if (isset($_POST["addNew"])) {

  $data = $_POST["data"];
  // $training = serialize($data[10]["Training"]);
  // $experience = serialize($data[11]);
  // $eligibility = serialize($data[10][$data[10][1]]);
  // $awards = serialize($data[10][$data[10][2]]);
  // $records = serialize($data[10][$data[10][3]]);

  $sql = "INSERT INTO `rsp_applicants` (`applicant_id`, `name`, `age`, `gender`, `civil_status`, `mobile_no`, `address`, `education`, `school`, `training`, `num_years_in_gov`, `experience`, `eligibility`, `awards`, `records_infractions`, `remarks`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("sississssisssss",
        $data[0],
        $data[1],
        $data[2],
        $data[3],
        $data[4],
        $data[5],
        $data[6],
        $data[7],
        serialize($data[10]),
        $data[8],
        serialize($data[14]),
        serialize($data[11]),
        serialize($data[12]),
        serialize($data[13]),
        $data[9],
);
  $stmt->execute();
  $stmt->close();


}