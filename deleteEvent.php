<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eventId'])) {
    $conn = new mysqli('localhost', 'root', '', 'evenimente_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $eventId = $_POST['eventId'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event: " . $stmt->error;
    }


    // header('Location: panouDeControl.php');
    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>