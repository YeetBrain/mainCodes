<?php
session_start();
include("connection.php"); // Ensure you have a proper database connection

// Check if the user is logged in and has a valid user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Prepare and execute a query to fetch the PDF
    $query = "SELECT report FROM gpa WHERE user_id = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($pdfData);
        $stmt->fetch();
        $stmt->close();

        if ($pdfData) {
            // Serve the PDF file for download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="GPA_Calculator_Report.pdf"');
            echo $pdfData;
        } else {
            echo "No PDF report found for this user.";
        }
    } else {
        echo "Error preparing statement: " . $con->error;
    }
} else {
    echo "User not logged in.";
}

