<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'arcade';

$mysqli = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_errno) {
    // Log error but don't expose details to users
    error_log("Database connection failed: " . $mysqli->connect_error);
    $mysqli = null;
} else {
    $mysqli->set_charset('utf8mb4');
}
?>
