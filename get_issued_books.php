<?php
include 'db_config.php';

$conn = make_connection();

$sql = "SELECT bm.book_id, bm.member_id, b.title AS book_title, m.name AS member_name, m.photo 
        FROM book_members bm
        JOIN books b ON bm.book_id = b.book_id
        JOIN members m ON bm.member_id = m.member_id
        WHERE b.is_issued = 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr><th>Book Title</th><th>Member Name</th><th>Photo</th><th>Actions</th></tr></thead><tbody>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr id="row-' . $row['book_id'] . '-' . $row['member_id'] . '">';
        echo '<td>' . htmlspecialchars($row['book_title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['member_name']) . '</td>';
        
        // Display the member's photo if available
        $photoPath = !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'images/';
        echo '<td><img src="' . $photoPath . '"  width="50" height="50"></td>';
        
        echo '<td>
                <button class="btn btn-primary edit-issue-btn" data-book-id="' . $row['book_id'] . '" data-member-id="' . $row['member_id'] . '">Edit</button>
                <button class="btn btn-danger delete-issue-btn" data-book-id="' . $row['book_id'] . '" data-member-id="' . $row['member_id'] . '">Delete</button>
              </td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
} else {
    echo '<p>No books currently issued.</p>';
}

$conn->close();
?>
