<?php
// Connect to the database
$db = new mysqli('localhost', 'root', '', 'evenimente_db');

// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user into the database
$sql = "INSERT INTO admin (email, password) VALUES ('$email', '$hashedPassword')";

if ($db->query($sql) === TRUE) {
  echo "Account created successfully!";
  header('Location: login.html');
} else {
  echo "Error creating account: " . $db->error;
}

// Close the database connection
$db->close();
