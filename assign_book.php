<?php
include 'db_config.php';

$conn = make_connection();

if (isset($_POST['book_id']) && isset($_POST['member_id'])) {
    $book_id = intval($_POST['book_id']);
    $member_id = intval($_POST['member_id']);
    $is_edit = isset($_POST['is_edit']) && $_POST['is_edit'] === 'true';

    if ($is_edit) {
        // Update the existing assignment
        $sql = "UPDATE book_members SET member_id = ? WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $member_id, $book_id);

        if ($stmt->execute()) {
            echo "<script>alert('Book assignment updated successfully!');</script>";
        } else {
            echo "<p class='text-danger'>Failed to update assignment. Please try again.</p>";
        }
        $stmt->close();
    } else {
        // Insert a new assignment
        $sql = "INSERT INTO book_members (book_id, member_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $book_id, $member_id);

        if ($stmt->execute()) {
            // Update the book's status to indicate it is issued
            $updateBookStatus = $conn->prepare("UPDATE books SET is_issued = 1 WHERE book_id = ?");
            $updateBookStatus->bind_param("i", $book_id);
            $updateBookStatus->execute();
            echo "<script>alert('Book issued successfully!');</script>";
        } else {
            echo "<p class='text-danger'>Failed to issue book. Please try again.</p>";
        }
        $stmt->close();
    }
} else {
    echo "<p class='text-danger'>Invalid request. Please try again.</p>";
}

$conn->close();
?>
