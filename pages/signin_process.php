<?php
session_start();
require_once '..\connect\db..php'; // Ensure correct file path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?)"); // Corrected SQL query
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, check password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password matched, set session variables for logged-in user
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;

            // Redirect to dashboard or some authenticated page
            header("Location: dashboard.php");
            exit();
        }
    }

    // If user not found or invalid credentials, redirect back with an error message
    $_SESSION['error_message'] = 'Invalid username/email or password.';
    header("Location: signin.php");
    exit();
} else {
    // If the form wasn't submitted, redirect back to the sign-in page
    header("Location: signin.php");
    exit();
}
?>
