<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("connection.php");
include("functions.php");

$error_message = ""; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Check if inputs are not empty and username is not numeric
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $con->prepare("SELECT * FROM gpa WHERE user_name = ? LIMIT 1");
        if ($stmt === false) {
            die("Error preparing statement: " . $con->error);
        }
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: home.php");
                die;
            } else {
                $error_message = "Username or password incorrect."; // Incorrect password
            }
        } else {
            $error_message = "Username or password incorrect."; // Username does not exist
        }
    } else {
        $error_message = "Please enter valid credentials."; // Invalid input
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        input[type="text"], input[type="password"] {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            margin-bottom: 10px;
            width: calc(100% - 12px); /* Adjust for padding */
        }
        input[type="submit"] {
            padding: 10px;
            width: 100%;
            color: white;
            background-color: lightblue;
            border: none;
            cursor: pointer;
            border-radius: 5px; /* Add rounded corners */
        }
        #box {
            background-color: grey;
            width: 300px;
            padding: 20px;
            margin: auto;
            border-radius: 5px;
            text-align: center;
        }
        #box div {
            font-size: 20px;
            margin: 10px;
        }

        #error_message_box{
            background-color: red;
            width: 250px;
            padding: 10px;
            margin: auto;
            border-radius: 5px;
            text-align: center;
        }
        .error-message {
            color: black;
            font-size: 16px;
            margin-top: 10px; /* Spacing above error message */
        }
    </style>
</head>
<body>
    <div id="box">
        <form method="post">
            <div>Login</div>
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (!empty($error_message)): ?>
                <div id = "error_message_box" class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <input type="submit" value="Login">
            <br>
            <a href="signup.php" style="font-size: 20px">Signup</a>
            <br>
            <a href="noLoginHome.html" style="font-size: 20px">Public Page</a>
        </form>
    </div>
</body>
</html>
