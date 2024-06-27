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

        body {
            background-color: #30a1da;
            background-image: url('https://gpacalclfa.s3.us-east-2.amazonaws.com/mainCodes/CalcImageNew.jpg');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .title {
            text-shadow:
                0 0 10px #FF6700;
            text-align: center;
            font-size: 50px;
            color: #f2f2f2;
            margin-top: 100px;
        }
        .info-text {
            background-color: #FFDBBB;
            overflow: hidden;
            padding: 20px 10px 20px 10px;
            position: relative;
            margin-left: 50px;
            margin-right: 50px;
            text-align: center;
            font-size: 20px;
            color: black;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .gpa-calculator {
            flex: 0 0 calc(50% - 40px);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 20px auto;
            border-radius: 25px;
            border: 2px solid #000000;
            box-sizing: border-box;
            width: 80%;
            max-width: 600px;
        }

        .identifier {
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            border-radius: 10px;
            border: 2px black;
            margin: 20px;
        }

        p1 {
            display: inline-block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
            font-family: "Raleway", serif;
            border-radius: 10px;
            margin: 40px;
            margin-top: 180px;
            background-color: #060c31;
        }

        p2 {
            background-color: rgba(24, 168, 190, 0.8);
            display: inline-block;
            color: #f2f2f2;
            text-decoration: none;
            text-align: center;
            font-size: 17px;
            font-family: "Raleway", serif;
            border-radius: 10px;
            margin: 0;
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .button-container, .button-container a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .button-container button, .button-container a {
            font-size: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: black;
            color: white;
            text-decoration: none;
            text-align: center;
        }

        .button-container button:hover, .button-container a:hover {
            background-color: #FF6700;
        }

        .container {
            position: relative;
            padding-bottom: 50px;
            width:auto;
            /* overflow-y:scroll; */

        }

        /* Container styling */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 45vh;
            font-family: Arial, sans-serif;
        }

        /* GPA calculator styling */
        .gpa-calculator {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        /* Header styling */
        .gpa-calculator h2, .gpa-calculator h3 {
            text-align: center;
            color: #333;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        /* Button styling */
        button {
            background-color: #FF6700;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin: 5px;
            display: block;
            width: calc(100% - 10px);
        }

        button:hover {
            background-color: #0056b3;
        }

        button:active {
            background-color: #004080;
        }


        /* Result styling */
        #gpaCalculator p {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        #gpaCalculator p:not(:empty) {
            margin-top: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>
<body>
    <header>
        <a href="noLoginHome.html" class="logo">EZCalc</a>
        <nav>
            <a href="noLoginHome.html" id="homeLink">Home</a>
            <a href="noLoginCalculator.html" class = "active" id="calculatorLink">Calculator</a>
            <a href="noLoginFaq.html" id="qaLink">FAQ</a>
                <a href="login.php">Login or Signup</a>
        </nav>
    </header>

    <h1 class = "title">
        LFA GPA Calculator
    </h1>

    <h2 class = "info-text">
        There are two calculators which use the LFA GPA system and the unweighted system respectively. It is cumulative and you can add/remove semesters and courses however you want. You can print a pdf report at the end.
    </h2>
    <br>
    <div class="container">
        <div class="gpa-calculator" id="gpaCalculator">
            <h2>LFA GPA Calculator</h2>
            <div id="semestersContainer">
                <div class="semester" id="semester1">
                    <h3>Semester 1</h3>
                    <table id="semester1Table">
                        <tr>
                            <th>Grade</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>
                                <select class="grade" required>
                                    <option value="4.33,4.0,A+">A+</option>
                                    <option value="4.0,4.0,A">A</option>
                                    <option value="3.67,4.0,A-">A-</option>
                                    <option value="3.33,3.0,B+">B+</option>
                                    <option value="3.0,3.0,B">B</option>
                                    <option value="2.67,3.0,B-">B-</option>
                                    <option value="2.33,2.0,C+">C+</option>
                                    <option value="2.0,2.0,C">C</option>
                                    <option value="1.67,2.0,C-">C-</option>
                                    <option value="1.33,1.0,D+">D+</option>
                                    <option value="1.0,1.0,D">D</option>
                                    <option value="0.67,1.0,D-">D-</option>
                                    <option value="0,0,F">F</option>
                                </select>
                            </td>
                            <td><input type="text" class="courseName" required></td>
                            <td><input type="number" min="0" max="4" step="0.5" class="credit" required /></td>
                            <td><button type="button" onclick="addCourse('semester1')">Add Course</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <button type="button" onclick="addSemester()">Add Semester</button>
            <button type="button" onclick="removeSemester()">Remove Semester</button>
            <button type="button" onclick="calculateGPA()">Calculate GPA</button>
            <p id="weightedGpaResult"></p>
            <p id="unweightedGpaResult"></p>
        </div>
    </div>
    <br>
    <div class="button-container">
        <button onclick="generatePDF()" >Generate PDF Report</button>
        <a href="login.php">Login or Signup to Save Latest PDF Report</a>
    </div>

    <div id="feedback"></div>

    <script>
        let latestPdfBlob = null;

        function addCourse(semesterId) {
            const semesterTable = document.getElementById(semesterId + "Table");
            const row = semesterTable.insertRow(-1);
            row.innerHTML = `
                <td>
                    <select class="grade" required>
                        <option value="4.33,4.0,A+">A+</option>
                        <option value="4.0,4.0,A">A</option>
                        <option value="3.67,4.0,A-">A-</option>
                        <option value="3.33,3.0,B+">B+</option>
                        <option value="3.0,3.0,B">B</option>
                        <option value="2.67,3.0,B-">B-</option>
                        <option value="2.33,2.0,C+">C+</option>
                        <option value="2.0,2.0,C">C</option>
                        <option value="1.67,2.0,C-">C-</option>
                        <option value="1.33,1.0,D+">D+</option>
                        <option value="1.0,1.0,D">D</option>
                        <option value="0.67,1.0,D-">D-</option>
                        <option value="0,0,F">F</option>
                    </select>
                </td>
                <td><input type="text" class="courseName" required></td>
                <td><input type="number" min="0" max="4" step="0.5" class="credit" required /></td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            `;
        }

        function addSemester() {
            const semesterContainer = document.getElementById("semestersContainer");
            const semesterCount = semesterContainer.querySelectorAll('.semester').length + 1;
            const newSemester = document.createElement('div');
            newSemester.className = 'semester';
            newSemester.id = `semester${semesterCount}`;
            newSemester.innerHTML = `
                <h3>Semester ${semesterCount}</h3>
                <table id="semester${semesterCount}Table">
                    <tr>
                        <th>Grade</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="grade" required>
                                <option value="4.33,4.0,A+">A+</option>
                                <option value="4.0,4.0,A">A</option>
                                <option value="3.67,4.0,A-">A-</option>
                                <option value="3.33,3.0,B+">B+</option>
                                <option value="3.0,3.0,B">B</option>
                                <option value="2.67,3.0,B-">B-</option>
                                <option value="2.33,2.0,C+">C+</option>
                                <option value="2.0,2.0,C">C</option>
                                <option value="1.67,2.0,C-">C-</option>
                                <option value="1.33,1.0,D+">D+</option>
                                <option value="1.0,1.0,D">D</option>
                                <option value="0.67,1.0,D-">D-</option>
                                <option value="0,0,F">F</option>
                            </select>
                        </td>
                        <td><input type="text" class="courseName" required></td>
                        <td><input type="number" min="0" max="4" step="0.5" class="credit" required /></td>
                        <td><button type="button" onclick="addCourse('semester${semesterCount}')">Add Course</button></td>
                    </tr>
                </table>
            `;
            semesterContainer.appendChild(newSemester);
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function removeSemester() {
            const semesterContainer = document.getElementById("semestersContainer");
            const semesters = semesterContainer.querySelectorAll('.semester');
            if (semesters.length > 0) {
                semesterContainer.removeChild(semesters[semesters.length - 1]);
            } else {
                alert("No semester to remove!");
            }
        }

        function calculateGPA() {
            const semestersContainer = document.getElementById("semestersContainer");
            const semesters = semestersContainer.querySelectorAll('.semester');
            let totalWeightedGradePoints = 0;
            let totalUnweightedGradePoints = 0;
            let totalCredits = 0;

            semesters.forEach((semester) => {
                const grades = semester.querySelectorAll('.grade');
                const credits = semester.querySelectorAll('.credit');

                grades.forEach((grade, index) => {
                    const [weightedGrade, unweightedGrade] = grade.value.split(',').map(Number);
                    const credit = parseFloat(credits[index].value);
                    totalWeightedGradePoints += weightedGrade * credit;
                    totalUnweightedGradePoints += unweightedGrade * credit;
                    totalCredits += credit;
                });
            });

            const weightedGPA = totalWeightedGradePoints / totalCredits;
            const unweightedGPA = totalUnweightedGradePoints / totalCredits;

            document.getElementById('weightedGpaResult').textContent = "Your Weighted GPA is: " + weightedGPA.toFixed(2);
            document.getElementById('unweightedGpaResult').textContent = "Your Unweighted GPA is: " + unweightedGPA.toFixed(2);
        }

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            let pdfContent = 'GPA Calculator Report\n\n';

            const semestersContainer = document.getElementById("semestersContainer");
            const semesters = semestersContainer.querySelectorAll('.semester');

            semesters.forEach((semester, index) => {
                pdfContent += `Semester ${index + 1}:\n`;
                const courses = semester.querySelectorAll('tr');
                courses.forEach((course, courseIndex) => {
                    if (courseIndex > 0) {
                        const grade = course.querySelector('.grade').value;
                        const courseName = course.querySelector('.courseName').value;
                        const credit = course.querySelector('.credit').value;
                        pdfContent += `Course: ${courseName}, Grade: ${grade.split(',')[2]}, Credits: ${credit}\n`;
                    }
                });
                pdfContent += '\n';
            });

            const weightedGpaResult = document.getElementById('weightedGpaResult').textContent;
            const unweightedGpaResult = document.getElementById('unweightedGpaResult').textContent;
            pdfContent += `${weightedGpaResult}\n`;
            pdfContent += `${unweightedGpaResult}\n`;

            doc.text(pdfContent, 10, 10);
            doc.save('GPA_Calculator_Report.pdf');

            // Create a Blob from the generated PDF and save it to a global variable
            latestPdfBlob = doc.output('blob');

            // Provide feedback that the PDF has been generated
            document.getElementById('feedback').textContent = "PDF has been generated successfully.";
        }

        document.addEventListener("DOMContentLoaded", function () {
            const homeLink = document.getElementById('homeLink');
            const calculatorLink = document.getElementById('calculatorLink');
            const qaLink = document.getElementById('qaLink');

            homeLink.addEventListener('click', function (event) {
                calculatorLink.classList.remove('active');
                qaLink.classList.remove('active');
            });

            calculatorLink.addEventListener('click', function (event) {
                homeLink.classList.remove('active');
                qaLink.classList.remove('active');
            });

            qaLink.addEventListener('click', function (event) {
                homeLink.classList.remove('active');
                calculatorLink.classList.remove('active');
            });
        });
    </script>
</body>
</html>
