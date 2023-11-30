<?php
// Start the session to access session variables
session_start();

// Include the database connection file
require_once '..\connect\db..php'; // Adjust the path as per your directory structure

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input and sanitize
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwords = $_POST['password'];

    $hashedPassword = password_hash($passwords, PASSWORD_DEFAULT);

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        // Registration successful, set session variables for the newly registered user
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;

        // Redirect to the dashboard or some authenticated page after successful sign-up
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle registration failure or database error
        $_SESSION['error_message'] = 'Registration failed. Please try again.';
        header("Location: signup.php");
        exit();
    }
} else {
    // If the form wasn't submitted, redirect back to the sign-up page
    header("Location: signup.php");
    exit();
}
?>
