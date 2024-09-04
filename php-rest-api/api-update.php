<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST'); // Changed to POST to match the AJAX request
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"), true);

$id = isset($data['sid']) ? $data['sid'] : null;
$name = isset($data['sname']) ? $data['sname'] : null;
$age = isset($data['sage']) ? $data['sage'] : null;
$city = isset($data['scity']) ? $data['scity'] : null;

include "config.php";

if ($id && $name && $age && $city) {
    // Prepare the SQL query to update the record
    $sql = "UPDATE student SET name = '{$name}', age = {$age}, city = '{$city}' WHERE id = {$id}";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array('message' => 'Student Record Updated.', 'status' => true));
    } else {
        echo json_encode(array('message' => 'Student Record Not Updated. Error: ' . mysqli_error($conn), 'status' => false));
    }
} else {
    echo json_encode(array('message' => 'Invalid Input.', 'status' => false));
}

?>
