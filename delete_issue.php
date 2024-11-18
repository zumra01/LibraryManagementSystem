<?php
include 'db_config.php';

$conn = make_connection();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Verify that both book_id and member_id are provided
if (isset($_POST['book_id']) && isset($_POST['member_id'])) {
    $book_id = intval($_POST['book_id']);
    $member_id = intval($_POST['member_id']);

    // SQL query to delete the issue record
    $sql = "DELETE FROM book_members WHERE book_id = ? AND member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $book_id, $member_id);

    // Execute the statement and handle success/failure
    if ($stmt->execute()) {
        echo "Issue deleted successfully!";
    } else {
        echo "Failed to delete issue: " . $stmt->error; // Provide specific error message
    }

    $stmt->close();
} else {
    echo "Invalid data provided.";
}

$conn->close();
?>
