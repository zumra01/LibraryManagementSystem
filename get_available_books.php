<?php
include 'db_config.php';

$conn = make_connection();

$sql = "SELECT book_id, title FROM books WHERE is_issued= 0"; // Modify your condition if needed
$result = $conn->query($sql);

$options = '';
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['book_id'] . "'>" . htmlspecialchars($row['title']) . "</option>";
}
echo $options;

$conn->close();
?>
