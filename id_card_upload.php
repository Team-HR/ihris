<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
require_once "_connect.db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['image']) && isset($_POST['employees_id'])) {
        $imageData = $_POST['image'];
        $employeeId = $_POST['employees_id'];
        $side = $_POST['side'];
        $type = 'jpeg';
        // Extract the base64 data and decode it
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo json_encode(['error' => 'Invalid image type']);
                exit;
            }

            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                echo json_encode(['error' => 'Base64 decode failed']);
                exit;
            }
        } else {
            echo json_encode(['error' => 'Invalid data URL']);
            exit;
        }

        $uploadDir = 'id_cards/';
        $uploadFile = $uploadDir . basename($employeeId . "_" . $side . ".{$type}");

        if (file_put_contents($uploadFile, $imageData)) {
            $sql = "UPDATE  `employee_id_cards` SET `printed_at` = CURRENT_TIMESTAMP WHERE `ihris_employee_id` = '$employeeId'";
            $mysqli->query($sql);
            echo json_encode(['message' => 'File is valid, and was successfully uploaded.']);
        } else {
            echo json_encode(['error' => 'Upload failed.']);
        }
    } else {
        echo json_encode(['error' => 'No image data or employee ID provided.']);
    }
}
