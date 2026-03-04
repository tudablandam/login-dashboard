<?php
session_start();
require_once "db.php";

$error = "";
$success = isset($_GET['success']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (in_array('', [$email, $password], true)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {

    $stmt = $conn->prepare("SELECT id, username, email, password, created_at FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['created_at'] = $user['created_at'];

        header("Location: dashboard.php");
        exit;
    }
    else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();

    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <h2>login</h2>

            <?php if ($success): ?>
                <p style="color:green;"> Registration successful! Please Log in.</p>
                <?php endif; ?>

            <?php if ($error): ?>
                <p style="color:red;"> <?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <p>Don't have an account? <a href="register.php">Register here</a></p>

        </div>
    </body>
</html>