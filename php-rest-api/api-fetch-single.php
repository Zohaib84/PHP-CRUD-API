<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Decode the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Extract the 'sid' from the data
$student_id = isset($data['sid']) ? $data['sid'] : null;

// Include the database configuration
include "config.php";

// Check if student ID is provided
if ($student_id) {
    // Prepare the SQL query to fetch the record by student ID
    $stmt = $conn->prepare("SELECT * FROM student WHERE id = ?");
    $stmt->bind_param("i", $student_id); // 'i' for integer

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any record is found
    if ($result->num_rows > 0) {
        // Fetch the data and convert it to JSON
        $output = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($output);
    } else {
        // No record found, return appropriate message
        echo json_encode(array('message' => 'No Record Found.', 'status' => false));
    }

    // Close the statement
    $stmt->close();
} else {
    // Student ID is missing in the request, return error
    echo json_encode(array('message' => 'Invalid Request.', 'status' => false));
}

// Close the database connection
$conn->close();
?>
