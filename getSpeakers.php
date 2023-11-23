<?php
// Establish a database connection (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenimente_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a specific speaker ID is provided in the request
if (isset($_GET['speaker_id'])) {
    $speakerId = $_GET['speaker_id'];

    // Fetch the specific speaker from the database
    $sql = "SELECT * FROM speakers WHERE id = $speakerId";
    $result = $conn->query($sql);

    // Check if the speaker was found
    if ($result->num_rows > 0) {
        $speaker = $result->fetch_assoc();

        // Close the database connection
        $conn->close();

        // Send the data as JSON
        header('Content-Type: application/json');
        echo json_encode($speaker);
        exit(); // Stop script execution after sending the response
    } else {
        // Speaker not found
        echo "Speaker not found.";
        exit();
    }
}

// If no specific speaker ID is provided, fetch all speakers
$sql = "SELECT * FROM speakers";
$result = $conn->query($sql);

// Convert the result to an associative array
$speakers = [];
while ($row = $result->fetch_assoc()) {
    $speakers[] = $row;
}

// Close the database connection
$conn->close();

// Send the data as JSON
header('Content-Type: application/json');
echo json_encode($speakers);
?>