<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $ticketPrice = $_POST['ticketPrice'];
    $speakerIds = $_POST['speakers']; // Assuming you allow multiple speakers
    $partnerIds = $_POST['partners']; // Assuming you allow multiple partners
    $sponsorIds = $_POST['sponsors']; // Assuming you allow multiple sponsors

    // File upload handling (if applicable)
    $imageFileName = "";  // Variable to store the image file name

    if (isset($_FILES['eventImage']) && $_FILES['eventImage']['error'] == 0) {
        // Process the uploaded file
        $imageFileName = handleImageUpload($_FILES['eventImage']);
    }

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'evenimente_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO events (title, start_date, start_time, end_date, end_time, location, description, ticket_price, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssss", $title, $startDate, $startTime, $endDate, $endTime, $location, $description, $ticketPrice, $imageFileName);

    // Execute the query
    $result = $stmt->execute();

    if ($result === false) {
        // Error executing query
        die("Error: " . $stmt->error);
    }

    // Get the last inserted event ID
    $eventId = $stmt->insert_id;

    // Insert speaker, partner, and sponsor relationships
    insertRelationships($conn, $eventId, $speakerIds, 'speaker_id');
    insertRelationships($conn, $eventId, $partnerIds, 'partner_id');
    insertRelationships($conn, $eventId, $sponsorIds, 'sponsor_id');

    // Event added successfully
    echo "Event added successfully";

    $stmt->close();
    $conn->close();
}

function insertRelationships($conn, $eventId, $ids, $columnName)
{
    foreach ($ids as $id) {
        // Update the events table to establish relationships
        $stmt = $conn->prepare("UPDATE events SET $columnName = ? WHERE id = ?");
        $stmt->bind_param("ii", $id, $eventId);

        // Execute the relationship query
        $result = $stmt->execute();

        if ($result === false) {
            // Error executing relationship query
            die("Error updating relationships: " . $stmt->error);
        }

        $stmt->close();
    }
}

function handleImageUpload($file)
{
    $targetDirectory = "assets/"; // Adjust this path to your desired upload directory
    $targetFile = $targetDirectory . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "Error: File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) {
        echo "Error: Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Error: Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Error: Your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
            return $targetFile; // Return the file path
        } else {
            echo "Error: There was an error uploading your file.";
        }
    }

    return "";
}

?>