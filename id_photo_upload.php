<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'id_photos/';
        $uploadFile = $uploadDir . basename($_POST["employees_id"] . ".jpg");

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            echo 'File is valid, and was successfully uploaded.';
        } else {
            echo 'Upload failed.';
        }
    } else {
        echo 'No file uploaded or there was an upload error.';
    }
}
