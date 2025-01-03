<?php

class Personnel
{
    private $employees_id;
    private $mysqli;

    function __construct()
    {
        require_once "../_connect.db.php";
        $this->mysqli = $mysqli;
        $this->employees_id = $_GET["id"];
    }

    public function get_employes_id()
    {
        $employees_id = $this->employees_id;
        // $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
        $sql = "SELECT * FROM `employees_card_number` WHERE `employees_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        $res = $res->fetch_assoc();
        return isset($res["empno"]) ? $res["empno"] : null;
    }

    public function get_name()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $name = $res["firstName"] . " ";
            $name .= isset($res["middleName"]) ? $res["middleName"][0] . ". " : "";
            $name .= $res["lastName"];
            $name .= isset($res["extName"]) ? " " . $res["extName"] : "";
            return $name;
        }
        return null;
    }

    public function get_employment_type()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $type = $res["employmentStatus"];
            return $type;
        }
        return null;
    }



    public function get_date_issued()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $res = $res["date_issued"];
            return mb_convert_case(dateFormat($res), MB_CASE_UPPER);
        }
        return null;
    }



    public function get_date_expire()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $res = $res["date_expire"];
            return mb_convert_case(dateFormat($res), MB_CASE_UPPER);
        }
        return null;
    }

    public function get_id_validation()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employee_id_cards` WHERE `ihris_employee_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $res = $res["date_expire"];
            if ($res < date('Y-m-d')) {
                return false;
            } else return true;
        }
        return null;
    }

    public function get_position()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $position_id = $res["position_id"];
            $sql = "SELECT * FROM `positiontitles` WHERE `position_id` = '$position_id'";
            $res = $this->mysqli->query($sql);
            if ($res = $res->fetch_assoc()) {
                $position = isset($res["position"]) ? $res["position"] : null;
                $position .= isset($res["functional"]) ? "<br>(" . $res["functional"] . ")" : null;
                return $position;
            }
            return null;
        }
        return null;
    }

    public function get_office()
    {
        $employees_id = $this->employees_id;
        $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employees_id'";
        $res = $this->mysqli->query($sql);
        if ($res = $res->fetch_assoc()) {
            $department_id = $res["department_id"];
            $sql = "SELECT * FROM `department` WHERE `department_id` = '$department_id'";
            $res = $this->mysqli->query($sql);
            if ($res = $res->fetch_assoc()) {
                $department = isset($res["department"]) ? $res["department"] : null;
                return $department;
            }
            return null;
        }
        return null;
    }
}

$emp = new Personnel();

function dateFormat($dateInput)
{
    if (!$dateInput) return null;
    $dateFormatted = new DateTimeImmutable($dateInput);
    return $dateFormatted->format('F d, Y');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>PrimeVue + CDN</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/primevue/umd/primevue.min.js"></script>
    <script src="https://unpkg.com/@primevue/themes/umd/aura.min.js"></script> -->
    <link rel="stylesheet" href="https://unpkg.com/primeflex@latest/primeflex.css">
    <link rel="stylesheet" href="https://unpkg.com/primeflex@latest/themes/primeone-light.css">
    <div id="app" class="w-full">
        <div class="inline-flex w-full">
            <!-- <div class="hidden md:block bg-primary font-bold align-items-center justify-content-center p-4 border-round mr-3">Hide on a small screen</div> -->
            <div class="block md:hidden align-items-center justify-content-center border-round w-full">
                <div class="mt-5 w-full flex align-items-center justify-content-center">
                    <img class="mr-2" src="../assets/images/bayawanSeal.png" style="width: 73px;">
                    <div class="align-items-center justify-content-center text-center">
                        <div class="text-2xl">ID VERIFICATION</div>
                        <div>LGU BAYAWAN CITY</div>
                    </div>
                </div>
                <div class="mt-5 w-full text-center text-xl"><?= $emp->get_name() ?></div>
                <div class="mt-1 w-full text-center text-md"><?= $emp->get_employment_type() ?></div>

                <?php
                if ($emp->get_id_validation()) {
                ?>
                    <div class="my-3 w-full text-center text-md bg-green-500 text-white py-3 text-3xl">VALIDATED</div>
                <?php } else { ?>
                    <div class="my-3 w-full text-center text-md bg-red-500 text-white py-3 text-3xl">NOT VALIDATED</div>
                <?php } ?>
                <div class="mt-1 w-full text-center text-md">DATE ISSUED: <?= $emp->get_date_issued() ?></div>
                <div class="mt-1 w-full text-center text-md">VALID UNTIL: <?= $emp->get_date_expire() ?></div>
                <div class="mt-3 w-full text-center text-sm">
                    For inquiries please visit/contact:
                    <br>
                    <b>OFFICE OF THE HUMAN RESOURCE MANAGEMENT &
                        DEVELOPMENT</b>
                    <br>
                    1st Floor, Legislative Building, Cabcabon Hills, Banga,
                    Bayawan City, Negros Oriental
                    <br>
                    Tel. No.:
                    <a href="tel:0354300263">(035) 430-0263 local 1065</a>
                    <br>
                    Fax No.:
                    <a href="tel:0354300222">(035) 430-0222</a>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</body>

</html>