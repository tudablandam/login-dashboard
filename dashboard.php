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

$password_error = "";
$password_success = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {

    require_once "db.php";

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    $password_error = "All fields are required.";
} elseif (strlen($new_password) < 6) {
    $password_error = "New password must be at least 6 characters.";
} elseif ($new_password !== $confirm_password) {
    $password_error = "New passwords do not match.";
} else {

        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        if ($result && password_verify($current_password, $result['password'])) {

            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $new_hash, $user_id);

            if ($update->execute()) {
                $password_success = "Password updated successfully.";
            } else {
                $password_error = "Error updating password.";
            }

            $update->close();

        } else {
            $password_error = "Current password is incorrect.";
        }

        $stmt->close();
    }
    $conn->close();
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
            <h2>Dashboard</h2>
            <p><strong>Welcome, </strong> <?= htmlspecialchars($_SESSION["username"]); ?>!</p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"]); ?></p>
            <p><strong>Member since:</strong> <?= htmlspecialchars($_SESSION["created_at"]); ?> </p>
        <h3>Change Password</h3>

<?php if (!empty($password_error)): ?>
    <p class="error"><?= htmlspecialchars($password_error); ?></p>
<?php endif; ?>

<?php if (!empty($password_success)): ?>
    <p class="success"><?= htmlspecialchars($password_success); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="password" name="current_password" placeholder="Current Password" required>
    <input type="password" name="new_password" placeholder="New Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
    <button type="submit" name="change_password">Update Password</button>
</form>
        <form method="POST" action="logout.php">
            <button type="submit">Logout</button>
        </form>

        </div>
    </body>
</html>