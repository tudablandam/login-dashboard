<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (in_array('', [$username, $email, $password], true)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username,email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <h2>Register</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username"><br><br>
        <input type="text" name="email" placeholder="Email"><br><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>

    </body>
</html>