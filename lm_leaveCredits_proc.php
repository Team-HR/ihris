<?php
require_once "_connect.db.php";
?>
<?php
    if (isset($_POST["addCredits"])) {    
        $employees_id = $_POST["employees_id"];
        $as_of = $_POST["as_of"];
        $vl = $_POST["vl"];
        $sl = $_POST["sl"];
        $sql = "INSERT INTO `lm_earnings` (`earning_id`, `emp_id`,`as_of`,`vl`, `sl`) VALUES (NULL, $employees_id, '$as_of', '$vl', '$sl')";
        $mysqli->query($sql);
    }
 ?> 