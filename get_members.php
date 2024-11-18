<?php
include 'db_config.php';

$conn = make_connection();

$sql = "SELECT member_id, name FROM members";
$result = $conn->query($sql);

$options = '';
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['member_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
}
echo $options;

$conn->close();
?>
