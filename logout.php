<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: login.php");
    exit();
}

session_unset();
session_destroy();

header("Location: login.php");
exit();