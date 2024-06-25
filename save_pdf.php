<?php
session_start();
include("connection.php"); // Ensure you have a proper database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf'])) {
    $pdfFile = $_FILES['pdf']['tmp_name'];
    $pdfData = file_get_contents($pdfFile);

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if the user already exists
        $checkQuery = "SELECT COUNT(*) FROM gpa WHERE user_id = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // Update existing record
            $query = "UPDATE gpa SET report = ? WHERE user_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $pdfData, $user_id);
        } else {
            // Insert new record
            $query = "INSERT INTO gpa (user_id, report) VALUES (?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('is', $user_id, $pdfData);
        }

        if ($stmt->execute()) {
            echo "PDF report saved successfully!";
        } else {
            echo "Error saving PDF report: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "User not logged in.";
    }
} else {
    echo "No PDF file received.";
}
?>
