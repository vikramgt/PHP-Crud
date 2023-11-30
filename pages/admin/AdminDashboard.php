<?php
// Start the session to access session variables
session_start();
require_once '..\..\connect\db..php';
// Check if the user is logged in; if not, redirect to the sign-in page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: signin.php");
    exit();
}

// Get the username of the logged-in user from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; // Default to 'Guest' if username not set
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin User Dashboard</title>
    <link rel="stylesheet" href="..\..\css\AdminDashboard.css">
</head>
<body>
    <h1>Welcome <?php echo $username; ?> to the Dashboard!</h1>
    <p>Click the button below to retrieve usernames:</p>
    
    <form action="AdminDashboard.php" method="post">
        <input type="submit" name="retrieveUsernames" value="Retrieve Usernames">
    </form>

    <?php
 
    // If the Retrieve Usernames button is clicked
    if (isset($_POST['retrieveUsernames'])) {
        // Query to retrieve usernames from the users table
        $stmt = $conn->prepare("SELECT username FROM users;"); // Corrected SQL query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output usernames in a list
            echo "<h2>Usernames:</h2><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["username"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "No usernames found";
        }
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>
