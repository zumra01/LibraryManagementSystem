<?php
include 'db_config.php';

$conn = make_connection();

$book_id = $_POST['book_id'];
$member_id = $_POST['member_id'];
$is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] === 'true';
$original_book_id = $_POST['original_book_id'];  // Retrieve the original book ID

if ($is_edit) {
    // Update existing issue
    $sql = "UPDATE book_members SET book_id = ?, member_id = ? WHERE book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $book_id, $member_id, $original_book_id);
    if ($stmt->execute()) {
        echo "Issue updated successfully!";
    } else {
        echo "Failed to update issue.";
    }
} 
$stmt->close();
$conn->close();

?>