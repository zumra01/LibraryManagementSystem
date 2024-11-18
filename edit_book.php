<?php
include 'db_config.php';

$conn = make_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];

    // SQL query to update the book data
    $sql = "UPDATE books SET title = ?, author = ?, genre = ?, publication_year = ? WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $author, $genre, $publication_year, $book_id);

    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully!');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();
?>
