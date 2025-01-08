<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <script src="login.js"></script>
</body>
</html>


<!-- JAVASCRIPT -->

document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // prevent form submission
    
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Make AJAX request to PHP script
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = "dashboard.php"; // Redirect to dashboard if login successful
                } else {
                    alert(response.message);
                    if (response.attemptsExceeded) {
                        document.getElementById("loginForm").reset(); // Reset form if attempts exceeded
                    }
                }
            } else {
                alert('Error: ' + xhr.status);
            }
        }
    };
    xhr.send("username=" + username + "&password=" + password);
});

<!-- PHP -->

<?php
session_start();

// Simulate user credentials (replace with your own authentication logic)
$valid_username = "user";
$valid_password = "pass";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the provided credentials are valid
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION["loggedin"] = true;
        $response = array("success" => true);
        echo json_encode($response);
    } else {
        // Track login attempts
        if (!isset($_SESSION["login_attempts"])) {
            $_SESSION["login_attempts"] = 1;
        } else {
            $_SESSION["login_attempts"]++;
        }

        // Check if login attempts exceed limit
        if ($_SESSION["login_attempts"] >= 3) {
            $response = array("success" => false, "message" => "Login failed. Maximum login attempts exceeded.", "attemptsExceeded" => true);
            $_SESSION["login_attempts"] = 0; // Reset attempts
        } else {
            $remaining_attempts = 3 - $_SESSION["login_attempts"];
            $response = array("success" => false, "message" => "Invalid username or password. You have $remaining_attempts attempts left.");
        }

        echo json_encode($response);
    }
} else {
    // If the request method is not POST, redirect back to the login page
    header("Location: index.html");
    exit;
}
?>
