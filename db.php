<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "login_system_v2";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}