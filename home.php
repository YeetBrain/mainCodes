<?php
session_start();
include("connection.php");
include("functions.php");
bfgjhbjhd

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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GPA Calculator</title>
  
  <!-- CSS for styling the page hi-->
  <style>
    /* General styles for the body and html, setting font and background color */
    body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #FEF1E4;
      overflow: scroll;
    }

    /* Styling for the main container holding all content */
    .container {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    /* Base styles for blocks within the container */
    .image-section, .calculator-section, .about-section {
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
      transition: height 0.5s ease;
    }

    /* Background image for the image section */
    .image-section {
      background-image: url('https://gpacalclfa.s3.us-east-2.amazonaws.com/mainCodes/CalcImage.jpg'); 
    }

    /* Styling for button containers, including hover effects */
    .button-container {
      background: rgba(0, 0, 0, 0.7);
      padding: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      border-radius: 25px;
      border: 2px solid #000000;
    }

    /* Hover effect for button containers */
    .button-container:hover {
      background: rgba(0, 0, 0, 0.9);
    }
    .logoutstyle{
            text-align: left;

        }

    /* Additional styling for calculator and about sections */
    .calculator-section, .about-section {
      background-color: #30a1da;
      padding: 25px;
      text-align: center;
      display: none;
    }

    /* Style to toggle display of sections */
    .show {
      display: block !important;
    }

    /* Navigation bar styling */
    .topnav {
      overflow: hidden;
      background-color: #060c31;
      text-align: center;
    }

    /* Link styling within the navigation bar */
    .topnav a {
      display: inline-block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
      font-size: 17px;
      font-family: "Raleway", serif;
      border-radius: 10px;
      background-color: #024fd4;
      margin: 0 5px;
      transition: background-color 0.3s ease;
    }

    /* Hover effects for navigation links */
    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }

    /* Style for active navigation link */
    .topnav a.active {
      background-color: #fff;
      color: #060c31;
    }

    /* Styling for headers and paragraphs */
    h1 { font-family: "Raleway", serif; }

    p { font-family: Palatino, "Palatino Linotype"; }
  </style>
</head>
<body>
  <!--This is the navbar which switches through the hyperlinks-->
  <div class="topnav">
    <a href="home.php" id="homeLink" class="active">Home</a>
    <a href="calculator.php" id="calculatorLink">Calculator</a>
    <a href="faq.php" id="qaLink">QA</a>
    <div class="logoutstyle">
            <a href="login.php"> Logout </a>
        </div>
  </div>

  <!-- Main container holding all sections -->
  <div class="container">
    <!-- Image section with welcome message -->
    <div class="image-section">
      <div class="button-container" onclick="slideDown()">
        <h1>Welcome to the Lake Forest Academy(LFA) GPA Calculator</h1>
      </div>
    </div>
    <!-- Calculator information section -->
    <div class="calculator-section">
      <h2><font size="7">Information about the Calculator</font></h2>
      <button style="height:30px;width:150px" onclick="slideToAbout()"><font size="4">About Section</font></button>
      <p><font size="5">On the calculator page there are two calculators which calculate LFA weighted GPA and unweighted GPA. LFA GPA system start out at A+ with it equal to 4.33 and deducts 0.33 for each grade below so A would be 4. Honors and AP classes do not affect it.</font></p>
    </div>
    <!-- About section with details about creators -->
    <div class="about-section">
      <h2><font size="7">About Us</font></h2>
      <button style="height:30px;width:180px" onclick="slideToCalculator()"><font size="4">Calculator Section</font></button>
      <p><font size="5">This calculator was made by Haricharan Yarlagadda and David Nguyen for FBLA Intro to Programming 2024.</font></p>
    </div>
  </div>

  <!-- JavaScript for handling navigation and section transitions -->
  <script>
    // Function to reveal the calculator section by sliding down the image section
    function slideDown() {
      var imageSection = document.querySelector('.image-section');
      var calculatorSection = document.querySelector('.calculator-section');
      
      imageSection.style.height = '50vh';
      calculatorSection.classList.add('show');
    }
    
    // Function to switch to the about section from calculator section
    function slideToAbout() {
      var aboutSection = document.querySelector('.about-section');
      var calculatorSection = document.querySelector('.calculator-section');
      
      calculatorSection.classList.remove('show');
      aboutSection.classList.add('show');
    }

    // Function to switch back to the calculator section from about section
    function slideToCalculator() {
      var aboutSection = document.querySelector('.about-section');
      var calculatorSection = document.querySelector('.calculator-section');
      
      aboutSection.classList.remove('show');
      calculatorSection.classList.add('show');
    }

    // Event listener to handle active class toggling for navigation links
    document.addEventListener("DOMContentLoaded", function() {
      const homeLink = document.getElementById('homeLink');
      const calculatorLink = document.getElementById('calculatorLink');
      const qaLink = document.getElementById('qaLink');
     
      homeLink.addEventListener('click', function(event) {
        calculatorLink.classList.remove('active');
        qaLink.classList.remove('active');
        homeLink.classList.add('active');
      });

      calculatorLink.addEventListener('click', function(event) {
        homeLink.classList.remove('active');
        qaLink.classList.remove('active');
        calculatorLink.classList.add('active');
      });

      qaLink.addEventListener('click', function(event) {
        homeLink.classList.remove('active');
        calculatorLink.classList.remove('active');
        qaLink.classList.add('active');
      });
    });
  </script>

</body>
</html>