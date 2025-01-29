<?php
header('Content-Type: application/json');

$uploadDir = "uploads/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES["logFile"]) || $_FILES["logFile"]["error"] !== UPLOAD_ERR_OK) {
    echo json_encode(["error" => "File upload failed."]);
    exit;
}

$timestamp = time();
$originalFilename = basename($_FILES["logFile"]["name"]);
$uploadedFile = $uploadDir . "log_" . $timestamp . "_" . $originalFilename;
move_uploaded_file($_FILES["logFile"]["tmp_name"], $uploadedFile);

$sshFailedPattern = "/Failed password for (invalid user )?([\w\d_-]+) from ([0-9.]+) port (\d+) ssh2/";
$bruteForcePattern = "/Connection closed by authenticating user ([\w\d_-]+) ([0-9.]+) port (\d+) \[preauth\]/";

$failedLogins = [];
$bruteForceAttempts = [];
$lines = file($uploadedFile);

foreach ($lines as $line) {
    if (preg_match($sshFailedPattern, $line, $matches)) {
        $failedLogins[] = ["timestamp" => substr($line, 0, 15), "user" => $matches[2], "ip" => $matches[3]];
    }
    if (preg_match($bruteForcePattern, $line, $matches)) {
        $ip = $matches[2];
        $bruteForceAttempts[$ip] = isset($bruteForceAttempts[$ip]) ? $bruteForceAttempts[$ip] + 1 : 1;
    }
}

echo json_encode(["failed_logins" => $failedLogins, "brute_force_attempts" => $bruteForceAttempts]);
?>
