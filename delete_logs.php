<?php
header('Content-Type: application/json');

$uploadDir = "uploads/";
$files = glob($uploadDir . "log_*");

foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

echo json_encode(["message" => "All uploaded log files have been deleted."]);
?>
