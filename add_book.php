<?php
include 'db_config.php';

// Get form input values
$title = $_POST['title'];
$author = $_POST['author'];
$genre = $_POST['genre'];
$publication_year = $_POST['publication_year'];

$conn = make_connection();

// Check if connection is available
if (!$conn) {
    die("Database connection failed");
}

// Prepare the SQL statement
$sql = "INSERT INTO books (title, author, genre, publication_year) VALUES ('$title', '$author', '$genre', '$publication_year')";

// Execute the query and check for errors
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('New Book added successfully!');</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
