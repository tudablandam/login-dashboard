<?php
session_start();

if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
}

$timeout = 300;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();

    header("Location: login.php?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time();
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
            <h2>Dashboard</h2>
            <p><strong>Welcome, </strong> <?= htmlspecialchars($_SESSION["username"]); ?>!</p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"]); ?></p>
            <p><strong>Member since:</strong> <?= htmlspecialchars($_SESSION["created_at"]); ?> </p>
        
        <form method="POST" action="logout.php">
            <button type="submit">Logout</button>
        </form>

        </div>
    </body>
</html>