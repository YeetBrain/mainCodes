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
    <title>GPA Calculator</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
            overflow: hidden;
            background-color: #060c31;
            text-align: center;
        }

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

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #fff;
            color: #060c31;
        }

        h1 {
            font-family: "Raleway", serif;
        }

        body {
            background-color: #30a1da;
            background-image: url('https://gpacalclfa.s3.us-east-2.amazonaws.com/mainCodes/CalcImageNew.jpg'); 
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
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

        p1, p2 {
            display: inline-block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
            font-family: "Raleway", serif;
            border-radius: 10px;
            margin: 40px;
            margin-top: 30px;
        }

        p2 {
            background-color: rgba(24, 168, 190, 0.8);
            margin-left: 350px;
        }

        p1 {
            background-color: #060c31;
        }

        .button-container {
            display: inline-block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            font-size: 17px;
            font-family: "Raleway", serif;
            border-radius: 10px;
            background-color: black;
            margin-left: 710px;
        }

        .container {
            position: relative;
            padding-bottom: 50px;
        }

        .logoutstyle {
            text-align: left;
        }

        #feedback {
            text-align: center;
            color: green;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="topnav">
        <a href="home.php" id="homeLink">Home</a>
        <a href="calculator.php" id="calculatorLink" class="active">Calculator</a>
        <a href="faq.php" id="qaLink">FAQ</a>
        <div class="logoutstyle">
            <a href="login.php"> Logout </a>
        </div>
    </div>

    <p2 style="font-family: Georgia">
        <font size="7">
            Weighted and Unweighted GPA Calculators
        </font>
    </p2>

    <p1 style="font-family: Georgia">
        <font size="5">
            On the calculator page, there are two calculators which use the LFA GPA system and the unweighted system respectively. It is cumulative and you can add semester and courses however you want. You can also remove courses and semesters. Just enter your letter grade for each course and its name along with credits. You can print a pdf report at the end.
        </font>
    </p1>

    <div class="identifier">
        <br>
        <br>
        <button onclick="generatePDF()" style="font-size: 20px; padding: 10px 20px; border: 2px solid #024fd4; border-radius: 5px; background-color: #060c31; color: white;">Generate PDF Report</button>
        <button onclick="savePDF()" style="font-size: 20px; padding: 10px 20px; border: 2px solid #024fd4; border-radius: 5px; background-color: #060c31; color: white;">Save Latest PDF Report</button>
        <button onclick="accessPDF()" style="font-size: 20px; padding: 10px 20px; border: 2px solid #024fd4; border-radius: 5px; background-color: #060c31; color: white;">Access Old PDF Report</button>
    </div>

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
            doc.save('GPA_Calculator_Report.pdf')

            // Create a Blob from the generated PDF and save it to a global variable
            latestPdfBlob = doc.output('blob');

            // Provide feedback that the PDF has been generated
            document.getElementById('feedback').textContent = "PDF has been generated successfully.";
        }

        function savePDF() {
            if (latestPdfBlob) {
                const formData = new FormData();
                formData.append('pdf', latestPdfBlob, 'GPA_Calculator_Report.pdf');

                fetch('save_pdf.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(result => {
                    document.getElementById('feedback').textContent = result;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert("Please generate a PDF first.");
            }
        }

        function accessPDF() {
            window.location.href = 'access_pdf.php';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const homeLink = document.getElementById('homeLink');
            const calculatorLink = document.getElementById('calculatorLink');
            const qaLink = document.getElementById('qaLink');

            homeLink.addEventListener('click', function(event) {
                calculatorLink.classList.remove('active');
                qaLink.classList.remove('active');
            });

            calculatorLink.addEventListener('click', function(event) {
                homeLink.classList.remove('active');
                qaLink.classList.remove('active');
            });

            qaLink.addEventListener('click', function(event) {
                homeLink.classList.remove('active');
                calculatorLink.classList.remove('active');
            });
        });
    </script>
</body>
</html>
