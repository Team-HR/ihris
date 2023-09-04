<?php
require_once "_connect.db.php";

if (isset($_POST["save_form"])) {
    # code...
    echo json_encode("saved successfully!");
}