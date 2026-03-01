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

        <div class="container">

            <h2> Dashboard </h2>

            <p><strong>Username:</strong><?php echo htmlspecialchars($_SESSION["username"]); ?></p>
            <p><strong>Email:</strong><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
            <p><strong>Created At:</strong><?php echo htmlspecialchars($_SESSION["created_at"]); ?></p>

            <br>
            <a href="logout.php">Logout</a>
        </div>
    </body>
</html>