<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "login_system";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection Failed");
}