<?php
require_once('vendor/autoload.php'); // Include the Stripe PHP library

\Stripe\Stripe::setApiKey('sk_test_51OFNsJIkmtRoILPuygkKzZFCef76nt6TdogKJpIVkEJ1APb5aIwiRbJQpvhXTGiOtS5YIRYPz2ljtIAelvKOSO4Q00e10msfaV'); // Set your Stripe Secret Key

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
    $imageFileName = "";

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

    // Create a product in Stripe for the event
    $product = \Stripe\Product::create([
        'name' => $title,
        'type' => 'service',
    ]);

    // Create a price for the product (assuming the ticket price is in cents)
    $price = \Stripe\Price::create([
        'product' => $product->id,
        'unit_amount' => $ticketPrice * 100, // Convert to cents
        'currency' => 'usd',
    ]);

    // Store the Stripe product and price IDs in your database for reference
    $stripeProductId = $product->id;
    $stripePriceId = $price->id;

    // Update the events table with the Stripe product and price IDs
    $updateStripeIdsStmt = $conn->prepare("UPDATE events SET stripe_product_id = ?, stripe_price_id = ? WHERE id = ?");
    if ($updateStripeIdsStmt === false) {
        die("Error preparing update statement: " . $conn->error);
    }

    $updateStripeIdsStmt->bind_param("ssi", $stripeProductId, $stripePriceId, $eventId);

    if (!$updateStripeIdsStmt->execute()) {
        // Error executing update query
        die("Error updating Stripe IDs: " . $updateStripeIdsStmt->error);
    }

    $updateStripeIdsStmt->close();

    // Create a Checkout Session


    // Redirect the user to the Stripe Checkout page
    header('Location:panouDeControl.php ');
    exit;

    $stmt->close();
    $conn->close();
}

function insertRelationships($conn, $eventId, $ids, $columnName)
{
    foreach ($ids as $id) {
        // Update the events table to establish relationships
        $stmt = $conn->prepare("UPDATE events SET $columnName = ? WHERE id = ?");
        if ($stmt === false) {
            die("Error preparing relationship update statement: " . $conn->error);
        }

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

    // Check if file is an actual image
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
    } else {
        // Read the file content
        $fileContent = file_get_contents($file["tmp_name"]);

        // Save the file content to the target directory
        if (file_put_contents($targetFile, $fileContent)) {
            echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
            return $targetFile; // Return the file path
        } else {
            echo "Error: There was an error uploading your file.";
        }
    }

    return "";
}