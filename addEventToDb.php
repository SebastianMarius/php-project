<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form data and database operations here
    // Example: Insert data into the 'events' table

    $conn = new mysqli('localhost', 'root', '', 'evenimente_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $title = $_POST['title'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $speakerId = $_POST['speakers'][0]; // Assuming you allow only one speaker for simplicity
    $partnerId = $_POST['partners'][0]; // Assuming you allow only one partner for simplicity
    $sponsorId = $_POST['sponsors'][0]; // Assuming you allow only one sponsor for simplicity

    // File upload handling
    $targetDir = "assets/"; // Adjust this to the desired directory

    if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == 0) {
        $fileName = basename($_FILES['eventImage']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['eventImage']['tmp_name'], $targetFile)) {
            // File was successfully uploaded
            $imagePath = './assets/' . $fileName; // Store relative path

            // Extract only the file name without the directory path
            $fileNameOnly = pathinfo($fileName, PATHINFO_FILENAME);

            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO events (title, start_date, start_time, end_date, end_time, location, description, speaker_id, partner_id, sponsor_id, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $title, $startDate, $startTime, $endDate, $endTime, $location, $description, $speakerId, $partnerId, $sponsorId, $imagePath);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Event added successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error uploading file
            echo "Error uploading file.";
        }
    } else {
        // No file uploaded or an error occurred
        echo "No file uploaded or an error occurred.";
    }

    // Close the connection
    $conn->close();
}
?>
