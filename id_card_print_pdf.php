<?php
require "_connect.db.php";

$employeeIds = $_GET["employeeIds"];
$departmentId = $_GET["departmentId"];

$sql = "SELECT * FROM `department` WHERE `department_id` = '$departmentId'";
$res = $mysqli->query($sql);
$row = $res->fetch_assoc();
$department = isset($row["alias"]) ? $row["alias"] : $row["department"];

$employeeIds = explode(",", $employeeIds);

$folders = [];

foreach ($employeeIds as $employee_id) {
    if ($name = getCardFileName($employee_id, $mysqli)) {
        $folders [] = 'id_cards/'.$name;
    }
}

$tempZipPath = __DIR__ . '/tmp_folders.zip';
$timestamp = date('Y-m-d-H-i');

if (zipMultipleFolders($folders, $tempZipPath)) {
    downloadZip($tempZipPath, 'IDs_'.$department.'-'.$timestamp.'.zip');
} else {
    echo "Failed to create ZIP.";
}

function getCardFileName($employee_id, $mysqli)
{
    $name = "";
    $sql = "SELECT * FROM `employees` WHERE `employees_id` = '$employee_id'";
    $res = $mysqli->query($sql);
    if ($employee = $res->fetch_assoc()) {
        $firstName = $employee["firstName"];
        $lastName = $employee["lastName"];
        $middleName = $employee["middleName"];
        $extName = $employee["extName"];

        $nameParts = [$lastName, $firstName];

        if ($middleName) {
            $nameParts[] = $middleName;
        }

        if ($extName) {
            $nameParts[] = $extName;
        }

        $nameParts = array_map(function ($part) {
            return str_replace(' ', '_', $part);
        }, array_filter([$lastName, $firstName, $middleName, $extName]));

        $name = implode('_', $nameParts);
        $name = cleanNamePart($name);
    }
    return $name;
}

function cleanNamePart($str)
{
    $str = str_replace(' ', '_', $str);   // Replace spaces with underscores
    $str = str_replace('.', '', $str);    // Remove periods
    return $str;
}

function zipMultipleFolders(array $folders, string $zipFilePath): bool
{
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return false;
    }

    foreach ($folders as $folder) {
        $folderPath = realpath($folder);
        if ($folderPath === false || !is_dir($folderPath)) {
            continue;
        }

        $folderName = basename($folderPath);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $folderName . '/' . substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    return $zip->close();
}

function downloadZip(string $zipFilePath, string $downloadName = 'folders.zip'): void
{
    if (!file_exists($zipFilePath)) {
        http_response_code(404);
        echo "ZIP file not found.";
        exit;
    }

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $downloadName . '"');
    header('Content-Length: ' . filesize($zipFilePath));
    readfile($zipFilePath);

    // Clean up
    unlink($zipFilePath);
}
