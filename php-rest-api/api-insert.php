<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields are present
if (!isset($data['sname']) || !isset($data['sage']) || !isset($data['scity'])) {
    echo json_encode(array('message' => 'Required fields are missing.', 'status' => false));
    exit();
}

$name = $data['sname'];
$age = $data['sage'];
$city = $data['scity'];

// Include database configuration
include "config.php";

// Use prepared statements to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO student (name, age, city) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $age, $city); // 's' for string, 'i' for integer

if ($stmt->execute()) {
    echo json_encode(array('message' => 'Student Record Inserted.', 'status' => true));
} else {
    echo json_encode(array('message' => 'Student Record Not Inserted.', 'status' => false));
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
