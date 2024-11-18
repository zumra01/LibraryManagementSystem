<?php
include 'db_config.php';

$conn = make_connection();

if (isset($_POST['book_id'])) {  // Use $_POST instead of $_GET
    $book_id = intval($_POST['book_id']);  // Ensure the book_id is sanitized

    $sql = "DELETE FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "success";  // Return success message
    } else {
        echo "Error deleting record: " . $conn->error;  // Provide error message
    }
    $stmt->close();
} else {
    echo "No book_id provided!";
}

$conn->close();
?>
