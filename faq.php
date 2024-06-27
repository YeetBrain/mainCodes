<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>

<?php
    if (isset($user_data['user_name'])) {
        echo htmlspecialchars($user_data['user_name']);
    } else {
        echo "User data not available.";
    }
    ?>


<!DOCTYPE html> 
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Calculator</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
            font-family: 'Poppins', sans-serif;
        }
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 120px;
            background: #11141a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }
        
        .logo {
            font-size: 25px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }
        nav a {
            font-size: 18px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            margin-left: 35px;
            transition: .3s;
        }
        nav a:hover,
        nav a.active {
            color: #FF6700;
        }

        body{
            background-image: url('https://gpacalclfa.s3.us-east-2.amazonaws.com/mainCodes/CalcImageNew.jpg'); 
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .heading-text {
            text-shadow:
                0 0 10px #FF6700;
            font-size: 50px;
            margin-top:auto;
            text-align: center;
            padding-top: 100px;
            color: white;
        }

        .question{
          
            color: white;
            padding: 20px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: gray;
        }

        .logoutstyle{
            text-align: left;

        }

        .answer {
            color:white;
            display: none;
            padding: 20px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: black;
        }
        p{
    display: inline-block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 20px; /* Adjust padding as needed */
    text-decoration: none;
    font-size: 17px;
    font-family: "Raleway", serif;
    border-radius: 10px; /* Adjust border radius as needed */
    background-color: #022156;
    margin-left: 300px;
    margin-right: 300px;
    margin-top: 30px;

}
    </style>
</head>

<body>
    <!--This is the navbar which switches through the hyperlinks-->
    <header>
        <a href="noLoginHome.html" class="logo">EZCalc</a>
        <nav>
            <a href="noLoginHome.html" id="homeLink">Home</a>
            <a href="noLoginCalculator.html" id="calculatorLink">Calculator</a>
            <a href="noLoginFaq.html" class = "active" id="qaLink">FAQ</a>
                <a href="login.php">Login or Signup</a>
        </nav>
    </header>

    <!--Directions for use, Header-->
    <h1 class = "heading-text">
            Frequently Asked Questions (FAQ)
    </h1>
    <div class="faq-section">
      <div class="question"><font size="4">What is Lake Forest Academy?</font></div>
      <div class="answer"><font size="4">Lake Forest Academy is a private high school located in Lake Forest, IL. It has day students and boarding students from all around the world.</font></div>

      <div class="question"><font size="4">How does the report work?</font></div>
      <div class="answer"><font size="4">It takes in all data entered by you and prints it out in a neat way with the GPA calculated at the end.</font></div>

      <div class="question"><font size="4">Can other schools use this?</font></div>
      <div class="answer"><font size="4">Lake Forest Academy GPA system is specific to it and we would advise you to check you GPA system. The unweighted system can be used by all.</font></div>

    </div>
    <!--This is the libraries for Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.question').click(function () {
                $(this).next('.answer').slideToggle();
            });
        });
    </script>
</body>

</html> 
