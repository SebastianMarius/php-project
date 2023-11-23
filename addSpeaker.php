<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve speaker details from the form
    $speakerName = isset($_POST["speakerName"]) ? $_POST["speakerName"] : '';
    $speakerDescription = isset($_POST["speakerDescription"]) ? $_POST["speakerDescription"] : '';

    // Save the uploaded file
    $targetDirectory = "assets/"; // Directory to store uploaded files
    $targetFile = $targetDirectory . basename($_FILES["speakerPhoto"]["name"]);

    // Check if both name and description are not empty
    if (!empty($speakerName) && !empty($speakerDescription)) {
        // Check if the file upload was successful
        if (move_uploaded_file($_FILES["speakerPhoto"]["tmp_name"], $targetFile)) {
            // File upload successful, proceed to add to the database

            // Extract the filename from the full path
            $filename = basename($targetFile);

            // Connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "evenimente_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the database connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Escape user inputs for security
            $speakerName = $conn->real_escape_string($speakerName);
            $speakerDescription = $conn->real_escape_string($speakerDescription);
            $filename = $conn->real_escape_string($filename);

            // Perform the SQL query
            $sql = "INSERT INTO speakers (name, description, photo) VALUES ('$speakerName', '$speakerDescription', '$filename')";

            if ($conn->query($sql) === TRUE) {
                echo "Speaker added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Speaker name and description cannot be empty.";
    }
}
?>