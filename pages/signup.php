<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/signup.css"> <!-- Link to your CSS file for signup styling -->
</head>
<body>
<div class="signup-form">
    <?php 
    session_start();
    if(isset($_SESSION['error_message']) && $_SESSION['error_message']) {
        echo "<script>
            alert('USER CREDENTIALS NOT FOUND. PLEASE SIGN UP');
        </script>";
        // After displaying the alert, clear the error message
        $_SESSION['error_message'] = '';
    }
    ?>
    <h2 class="form-title">Sign Up</h2>
    <div class="input-container">
        <form action="signup_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="signin.php">Sign In</a></p>
    </div>
</div>

</body>
</html>
