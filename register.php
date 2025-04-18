<?php
include 'config.php';
session_start();

$username = $email = $password = $confirm_password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate input
    if (empty($username)) $errors[] = "Username is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into DB
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($insert_stmt->execute()) {
                $_SESSION['success'] = "Registration successful. Please log in.";
                header("Location: login.php");
                exit;
            } else {
                $errors[] = "Error in registration.";
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!-- Tailwind CSS Register Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" class="w-full border p-2 mb-4 rounded" required>
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-4 rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-4 rounded" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full border p-2 mb-4 rounded" required>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Register</button>
    </form>

    <p class="mt-4 text-center text-sm">Already have an account? <a href="login.php" class="text-blue-600">Login</a></p>
</div>
</body>
</html>
