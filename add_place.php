<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database connection
$host = 'localhost';
$dbname = 'travelgo';
$user = 'root';
$pass = ''; // update if needed

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed']);
    exit;
}

// Read and decode JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required = ['country', 'place', 'description', 'image', 'rating', 'name', 'email'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['message' => "Missing field: $field"]);
        exit;
    }
}

// Sanitize input
$country     = $conn->real_escape_string($data['country']);
$place       = $conn->real_escape_string($data['place']);
$description = $conn->real_escape_string($data['description']);
$image       = $conn->real_escape_string($data['image']);
$rating      = floatval($data['rating']);
$user_name   = $conn->real_escape_string($data['name']);
$email       = $conn->real_escape_string($data['email']);
$message     = isset($data['message']) ? $conn->real_escape_string($data['message']) : '';

// Insert into database
$sql = "INSERT INTO enquiries (country, place, description, image, rating, user_name, email, message)
        VALUES ('$country', '$place', '$description', '$image', $rating, '$user_name', '$email', '$message')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => 'Place successfully added to enquiry list']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to add place: ' . $conn->error,
    'sql' =>$sql
]);
}

$conn->close();
?>
