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
<html lang="en">
<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Signup</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .error-message {
            color: red;
            font-size: 20px;
        }
        .login-link {
            display: block;
            color: #007bff;
            text-decoration: none;
        }
        
        .wrapper {
            position: relative;
            width: 400px;
            height: 500px;
            background: #000;
            box-shadow: 0 0 50px #FF6700;
            border-radius: 20px;
            padding: 40px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper:hover {
            animation: animate 1s linear infinite;
        }
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            transition: 1s ease-in-out;
            flex-direction: column;
        }
        .wrapper.active .form-wrapper.sign-in {
            transform: translateY(-450px);
        }
        .form-wrapper h1 {
            font-size: 30px;
            color: #fff;
            text-align: center;
        }
        .input-box {
            position: relative;
            border-bottom: 2px solid #fff;
            margin: 30px 0;
        }
        .input-box i {
            position: absolute;
            right: 20px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #fff;
        }
        .input-box label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }
        .input-box input {
            width: 320px;
            height: 40px;
            font-size: 16px;
            color: #fff;
            padding: 0 5px;
            background: transparent;
            border: none;
            outline: none;
        }
        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -1px;
        }
        button {
            position: relative;
            width: 100%;
            height: 40px;
            background: #D2B48C;
            box-shadow: 0 0 10px #FF6700;
            font-size: 16px;
            color: #000;
            font-weight: 500;
            cursor: pointer;
            border-radius: 30px;
            border: none;
            outline: none;
        }
        .signUp-link {
            font-size: 14px;
            text-align: center;
            margin: 15px 0;
        }
        .signUp-link p {
            color: #fff;
        }
        .signUp-link p a {
            color: #FF6700;
            text-decoration: none;
            font-weight: 500;
        }
        .signUp-link p a:hover {
            text-decoration: underline;
        }
        .guest-access {
            text-align: center;
            color: #FF6700;
            font-weight: 500;
            text-decoration: none;
        }
        .guest-access a:hover {
            text-decoration: underline;
        }
        a:visited { 
            text-decoration: none; 
            color: #FF6700; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="form-wrapper sign-in">
            <form method="post">
                <h1>Sign Up</h1>
                <div class="input-box">
                    <i class='bx bxs-user'></i>
                    <input type="text" name="user_name" placeholder="Username" required>
                </div> 
                <div class="input-box">
                    <i class='bx bxs-lock'></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                <button type="submit">Sign Up</button>
                <br>
                <div class="signUp-link">
                    <p>Already have an account? <a href="login.php" class="signUpBtn-link">Login</a></p>
                </div>
                <div class="guest-access">
                    <a href="noLoginHome.html">Guest Access</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
