<?php
include 'db_config.php';

$conn = make_connection();

$sql = "SELECT * FROM books"; // Change this to your table (e.g., `members`) if you need member data
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered table-striped">';
    echo '<thead><tr><th>Title</th><th>Author</th><th>Genre</th><th>Publication Year</th><th>Actions</th></tr></thead><tbody>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr id="row-' . $row['book_id'] . '">';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['author']) . '</td>';
        echo '<td>' . htmlspecialchars($row['genre']) . '</td>';
        echo '<td>' . htmlspecialchars($row['publication_year']) . '</td>';
        echo '<td>
                <button class="btn btn-primary edit-btn" data-id="' . $row['book_id'] . '">Edit</button>
                <button class="btn btn-danger delete-btn" data-id="' . $row['book_id'] . '">Delete</button>
              </td>';
        echo '</tr>';
    }
    
    echo '</tbody></table>';
} else {
    echo '<p>No records found.</p>';
}

$conn->close();
?>

<!-- Add JavaScript for Delete Functionality
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.delete-btn').click(function() {
        var bookId = $(this).data('id'); // Get book ID from button

        if (confirm("Are you sure you want to delete this book?")) {
            $.ajax({
                url: 'delete_book.php', // PHP script to handle deletion
                type: 'POST',
                data: { book_id: bookId },
                success: function(response) {
                    if (response == 'success') {
                        $('#row-' + bookId).remove(); // Remove row from table
                        alert("Book deleted successfully!");
                    } else {
                        alert("Failed to delete the book. Please try again.");
                    }
                }
            });
        }
    });
});
</script> -->
