<?php
// Include config file
require_once "_connect.db.php";
require_once "libs/models/Employee.php";
$emp = new Employee;

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if (isset($_POST["login"])) {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
        echo "0";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
        echo "1";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {

        $sql = "SELECT `spms_accounts`.`acc_id` AS `id`, `spms_accounts`.`username`, `spms_accounts`.`employees_id`, `spms_accounts`.`password`, `spms_accounts`.`type`, `employees`.`department_id` FROM `spms_accounts` LEFT JOIN `employees` ON `spms_accounts`.`employees_id` = `employees`.`employees_id` WHERE `username` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $param_username);
        $param_username = $username;
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            // Check if username exists, if yes then verify password
            if ($stmt->num_rows > 0) {
                // Bind result variables
                $stmt->bind_result($id, $username, $employees_id, $hashed_password, $type, $department_id);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        session_start();
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["employee_id"] = $employees_id;
                        $_SESSION["department_id"] = $department_id;
                        $_SESSION["full_name"] = $emp->get_full_name_upper($_SESSION["employee_id"]);
                        $_SESSION["username"] = $username;
                        $_SESSION["roles"] = explode(",", $type);
                        // ###############################################################
                        // office_role - object identifying user role in the current department
                        // db tables: office_supervisors and office_subordinates
                        $_SESSION["supervisory"] = get_supervisory_data($mysqli2, $employees_id);
                        // Good afternoon po from LGU Bayawan City
                        // $_SESSION["is_admin"] = in_array("HR",);
                        // Redirect user to welcome page
                        // header("location: index.php");
                        if ($type === null) {
                            echo "6";
                            // echo "2";
                        } elseif ($type === "denied") {
                            echo "7";
                        } else {
                            echo "2";
                        }
                    } else {
                        // Display an error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                        echo "3";
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                $username_err = "No account found with that username.";
                echo "4";
            }
        } else {
            // echo "Oops! Something went wrong. Please try again later.";
            echo "5";
        }

        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
} elseif (isset($_POST["register"])) {
    $usrdata = $_POST["usrdata"];
    $name = $usrdata[0] . " " . $usrdata[1] . " " . $usrdata[2] . " " . $usrdata[3];
    $username = $usrdata[4];
    $password = $usrdata[5];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, username, password) VALUES (?,?,?)";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sss", $name, $username, $password_hashed);
        if ($stmt->execute()) {
            echo "0";
        } else {
            echo "1";
        }
    }

    $stmt->close();
    $mysqli->close();
}

function get_supervisory_data($mysqli2, $employee_id)
{
    $sql = "SELECT `superiors`.`id` AS `superior_id`, `superiors`.`office_id`, `offices`.`office`, `offices`.`department_id`, `departments`.`department` FROM `superiors` LEFT JOIN `offices` ON `superiors`.`office_id` = `offices`.`id` LEFT JOIN `departments` ON `offices`.`department_id` = `departments`.`id` WHERE `employee_id` = '$employee_id';";
    $result = $mysqli2->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function getEmployeeName($employees_id)
{
    $full_name = "";
    $full_name = $employees_id;
    return $full_name;
}
