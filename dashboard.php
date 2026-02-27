<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <h2> Dashboard </h2>

        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>!</p>

        <a href="logout.php">Logout</a>

    </body>
</html>