<?php
session_start();
include("connection.php"); 
include("functions.php");

$error_message = ""; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Validate input
    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Check if username already exists
        $stmt = $con->prepare("SELECT user_name FROM gpa WHERE user_name = ? LIMIT 1");
        if ($stmt === false) {
            die("Error preparing statement: " . $con->error);
        }
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error_message = "Username already taken. Please choose another one.";
        } else {
            $user_id = random_num(20);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert new user
            $stmt = $con->prepare("INSERT INTO gpa (user_id, user_name, password) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Error preparing statement: " . $con->error);
            }
            $stmt->bind_param("sss", $user_id, $user_name, $hashed_password);
            if ($stmt->execute()) {
                header("Location: login.php");
                die;
            } else {
                $error_message = "Error creating user. Please try again.";
            }
        }
    } else {
        $error_message = "Please enter valid information.";
    }
}

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }
    $len = rand(4, $length);
    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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
        .error-message {
            color: red;
            font-size: 16px;
            margin-top: 10px; /* Spacing above error message */
        }
    </style>
</head>
<body>
    <div id="box">
        <form method="post">
            <div>Signup</div>
            <input type="text" name="user_name" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <input type="submit" value="Signup">
            <br>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>
