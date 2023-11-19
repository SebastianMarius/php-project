<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form data and database operations here
    // Example: Insert data into the 'events' table

    $conn = new mysqli('localhost', 'root', '', 'evenimente_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $_POST['title'];
    // Repeat for other form fields

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO events (title, start_date, start_time, end_date, end_time, location, description, speaker_id, partner_id, sponsor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $title, $startDate, $startTime, $endDate, $endTime, $location, $description, $speakerId, $partnerId, $sponsorId);

    // Assign values to variables (use the actual form field names)
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $speakerId = $_POST['speakers'][0]; // Assuming you allow only one speaker for simplicity
    $partnerId = $_POST['partners'][0]; // Assuming you allow only one partner for simplicity
    $sponsorId = $_POST['sponsors'][0]; // Assuming you allow only one sponsor for simplicity

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Event added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>