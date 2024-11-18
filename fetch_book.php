<?php
include 'db_config.php';

$conn = make_connection();

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);
    $sql = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        echo json_encode($book); // Return book data as JSON
    } else {
        echo "No book found!";
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();
?>
