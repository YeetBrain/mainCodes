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

        html, body {
            height: 100%;
        }

        body {
            background-image: url('blurImg.png');
    min-height: 100vh;
    background-position: center;
    background-size: cover;
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

        .title {
            text-shadow: 0 0 10px #FF6700;
            text-align: center;
            font-size: 50px;
            color: #f2f2f2;
            margin-top: 100px;
        }

        .info-text {
            background-color: #FFDBBB;
            overflow: hidden;
            padding: 20px 10px;
            position: relative;
            margin-left: 50px;
            margin-right: 50px;
            text-align: center;
            font-size: 20px;
            color: black;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 15px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 50px;
        }

        .gpa-calculator {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            margin: 20px;
            border-radius: 25px;
            border: 2px solid #000000;
            box-sizing: border-box;
            width: 80%;
            max-width: 600px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .button-container button,
        .button-container a {
            font-size: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: black;
            color: white;
            text-decoration: none;
            text-align: center;
            flex: 1;
            display: inline-block;
        }

        .button-container button:hover,
        .button-container a:hover {
            background-color: #FF6700;
        }

        .button-container a {
            display: flex;
            align-items: center;
            justify-content: center;
        }

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
            background-color: #000000;
        }

        button:active {
            background-color: #000000;
        }

        #gpaCalculator p {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        #gpaCalculator p:not(:empty) {
            margin-top: 20px;
        }
        .button-container button,
.button-container a {
    font-size: 20px;
    padding: 10px 20px;
    border-radius: 5px;
    background-color: black;
    color: white;
    text-decoration: none;
    text-align: center;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box; /* Ensure box-sizing is applied */
    margin-bottom: 50px;
}

.button-container button:hover,
.button-container a:hover {
    background-color: #FF6700;
}

.button-container button {
    margin: 0; /* Remove any extra margins that might affect size */
}

.button-container a {
    margin: 0; /* Remove any extra margins that might affect size */
}

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>

<body>
    <header>
        <a href="home.php" class="logo">EZCalc</a>
        <nav>
            <a href="home.php" id="homeLink">Home</a>
            <a href="calculator.php" class="active" id="calculatorLink">Calculator</a>
            <a href="faq.php" id="qaLink">FAQ</a>
            <a href="login.php">Logout</a>
        </nav>
    </header>

    <h1 class="title">
        LFA GPA Calculator
    </h1>

    <h2 class="info-text">
    There is one calculator which allows for user to calculate weighted and unweighted GPA. You can add and remove semesters and courses to your liking. Add the grade, course name, and number of credits for the semester to each class. Once you calculate your gpa, you can generate a pdf and save it into the database. This can be accessed for future use and reference.
    </h2>

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

    <div class="button-container">
    <button type = "button" onclick="generatePDF()" >Generate PDF Report</button>
        <button type = "button" onclick="savePDF()" >Save Latest PDF Report</button>
        <button  type = "button" onclick="accessPDF()" >Access Old PDF Report</button>
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
                alert("PDF generated sucessfully!");
            } else {
                alert("Please generate a PDF first.");
            }

            
        }
        function accessPDF() {
            window.location.href = 'access_pdf.php';
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
