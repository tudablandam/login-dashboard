<?php
require_once "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

if (in_array("", [$username, $email, $password], true)) {
    $error = "All fields are required.";
}  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
} else {

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = ("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashPassword);

    if ($stmt->execute()) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error = "error: " . $stmt->error;
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
        <title>Register</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <h2>Register</h2>
            <?php if ($error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>

                <p>Already have an account? <a href="login.php">Login here</a>.</p>

        </div>
    </body>
</html>