<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "travelgo");

if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "Database connection failed"]);
  exit();
}

$sql = "SELECT * FROM enquiries ORDER BY id DESC";
$result = $conn->query($sql);

$places = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $places[] = $row;
  }
}

echo json_encode($places);
$conn->close();
?>
