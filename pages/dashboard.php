<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in; if not, redirect to the sign-in page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: signin.php");
    exit();
}

// Get the username of the logged-in user from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; // Default to 'Guest' if username not set

// Database connection
require_once '..\connect\db..php';

// CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $content = isset($_POST['content']) ? $_POST['content'] : '';

        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO crud_table (content) VALUES (?);");
        $stmt->bind_param("s", $content);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';

        // Update the database
        $stmt = $conn->prepare("UPDATE crud_table SET content = ? WHERE id = ?;");
        $stmt->bind_param("si", $content, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : '';

        // Delete from the database
        $stmt = $conn->prepare("DELETE FROM crud_table WHERE id = ?;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Retrieve data from the crud_table
$stmt = $conn->prepare("SELECT id, content FROM crud_table;");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>This is your dashboard. You can add content, display user-specific information, or provide navigation links here.</p>

    <form action="dashboard.php" method="post">
        <label for="content">Content:</label>
        <input type="text" id="content" name="content" required>

        <!-- Add, Update, Delete, and Clear buttons -->
        <button type="submit" name="add">Add</button>
        <button type="submit" name="update">Update</button>
        <button type="submit" name="delete">Delete</button>
        <button type="reset">Clear</button>
    </form>

    <h3>CRUD Table:</h3>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row["content"] . 
                " <form action='dashboard.php' method='post'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <input type='text' name='content' value='" . $row['content'] . "'>
                      <button type='submit' name='update'>Update</button>
                      <button type='submit' name='delete'>Delete</button>
                  </form>
                </li>";
        }
        ?>
    </ul>

    <!-- Example: Logout link -->
    <a href="logout.php">Logout</a> <!-- Create a logout.php file to handle logout functionality -->

    <!-- Add more content or links as per your application's requirements -->

</body>
</html>
