<?php
// Start the session to access session variables
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the sign-in page or any other desired page after logout
header("Location: signin.php");
exit();
?>
