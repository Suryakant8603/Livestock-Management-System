<?php
include 'config.php';
session_start();

$email = $password = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Tailwind CSS Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <?php if (!empty($_SESSION["success"])): ?>
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            <?= $_SESSION["success"]; unset($_SESSION["success"]); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-4 rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-4 rounded" required>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Login</button>
    </form>

    <p class="mt-4 text-center text-sm">Don't have an account? <a href="register.php" class="text-blue-600">Register</a></p>
</div>
</body>
</html>
