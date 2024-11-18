// Fetch and display inventory via Ajax
function viewInventory() {
  $.ajax({
    url: "fetch_data.php",
    type: "GET",
    success: function (data) {
      $("#inventoryTable").html(data);
    },
    error: function () {
      $("#inventoryTable").html("<p class='text-danger'>Failed to load inventory.</p>");
    }
  });
}
// Show section based on navigation
function showSection(sectionId) {
  // Hide all sections first
  document.querySelectorAll("section").forEach(section => {
    section.style.display = "none";
  });
  
  // Show the specific section
  const section = document.getElementById(sectionId);
  if (section) {
    section.style.display = "block"; // Make sure the section is visible

    // Apply background image only for 'home' section
    if (sectionId === "home") {
      section.style.backgroundImage = "url('https://images.unsplash.com/photo-1491841573634-28140fc7ced7?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHx8fA%3D%3D')";
      section.style.backgroundSize = "cover"; // Ensure the image covers the entire section
      section.style.backgroundPosition = "center"; // Center the image
      section.style.backgroundRepeat = "no-repeat"; // Ensure the image doesn't repeat
      section.style.height = "100vh";  // Ensure it takes the full viewport height
    section.style.width = "100%";  //
      
    }
  } else {
    console.error("Section with id '" + sectionId + "' not found.");
  }

  // Additional logic for other sections
  if (sectionId === "viewInventory") {
    viewInventory(); // Load inventory via Ajax
  }
  if (sectionId === "issueBook") {
    loadAvailableBooks();
    loadMembers();
  }
}




// Submit Add Book form via Ajax
$(document).ready(function () {
  $("#bookForm").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
      url: "add_book.php",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        $("#bookFormResponse").html(response);
        $("#bookForm")[0].reset();
      },
      error: function () {
        $("#bookFormResponse").html("<p class='text-danger'>Failed to add book. Please try again.</p>");
      }
    });
  });

  // Submit Add Member form via Ajax
 // Submit Add Member form via Ajax
$("#memberForm").on("submit", function (e) {
  e.preventDefault();
  var formData = new FormData(this); // Use FormData for file uploads

  $.ajax({
      url: "add_member.php",
      type: "POST",
      data: formData, // Pass the formData object
      processData: false, // Prevent jQuery from processing data
      contentType: false, // Prevent jQuery from setting content type
      success: function (response) {
          $("#memberFormResponse").html(response);
          $("#memberForm")[0].reset();
      },
      error: function () {
          $("#memberFormResponse").html("<p class='text-danger'>Failed to add member. Please try again.</p>");
      }
  });
});


  

  // Delete book functionality
  $(document).on("click", ".delete-btn", function() {
    var bookId = $(this).data('id');  // Get book ID from button

    if (confirm("Are you sure you want to delete this book?")) {
        $.ajax({
            url: 'delete_book.php',  // PHP script to handle deletion
            type: 'POST',
            data: { book_id: bookId },  // Send book_id as POST data
            success: function(response) {
                if (response.trim() === 'success') {
                    $('#row-' + bookId).remove();  // Remove the row from the table
                    alert("Book deleted successfully!");
                } else {
                    alert("Failed to delete the book. Please try again.");
                }
            },
            error: function() {
                alert("An error occurred. Please try again.");
            }
        });
    }
});

// Show the edit form with the current book data
$(document).on("click", ".edit-btn", function() {
  var bookId = $(this).data('id'); // Get the book ID

  // Use Ajax to fetch book data based on ID
  $.ajax({
    url: 'fetch_book.php',
    type: 'GET',
    data: { book_id: bookId },
    success: function(response) {
      var book = JSON.parse(response);
      if (book) {
        // Populate the form with the current book data
        $("#editBookId").val(book.book_id);
        $("#editTitle").val(book.title);
        $("#editAuthor").val(book.author);
        $("#editGenre").val(book.genre);
        $("#editPublicationYear").val(book.publication_year);
        showSection('editBook'); // Show the edit form
      } else {
        alert("Book not found.");
      }
    },
    error: function() {
      alert("Failed to fetch book data.");
    }
  });
});

// Submit the edit form via Ajax
$("#editBookForm").on("submit", function(e) {
  e.preventDefault();
  $.ajax({
    url: 'edit_book.php',
    type: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      $("#editBookResponse").html(response);
      if (response == 'Record updated successfully!') {
        viewInventory(); // Reload inventory
        showSection('viewInventory'); // Show inventory section
      }
    },
    error: function() {
      $("#editBookResponse").html("<p class='text-danger'>Failed to update book. Please try again.</p>");
    }
  });
});



});
// Load available books
function loadAvailableBooks() {
  $.ajax({
    url: 'get_available_books.php', // Backend PHP script to fetch available books
    type: 'GET',
    success: function (data) {
      $('#bookDropdown').html(data); // Populate the dropdown
    },
    error: function () {
      alert("Error loading available books.");
    }
  });
}
function loadIssuedBooks() {
  $.ajax({
      url: 'get_issued_books.php',
      type: 'GET',
      success: function (response) {
          $('#issuedBooksTable').html(response);
      }
  });
}
// Load members
function loadMembers() {
  $.ajax({
    url: 'get_members.php', // Backend PHP script to fetch members
    type: 'GET',
    success: function (data) {
      $('#memberDropdown').html(data); // Populate the dropdown
    },
    error: function () {
      alert("Error loading members.");
    }
  });
  loadIssuedBooks();

}

// // Trigger loading when the Issue Book section is displayed
// function showSection(sectionId) {
//   document.querySelectorAll("section").forEach(section => {
//     section.style.display = "none";
//   });
//   document.getElementById(sectionId).style.display = "block";
  
//   if (sectionId === "issueBook") {
//     loadAvailableBooks();
//     loadMembers();
//   }
// }
// Submit Issue Book form
$("#issueBookForm").on("submit", function (e) {
  e.preventDefault();
  $.ajax({
    url: 'assign_book.php',
    type: 'POST',
    data: $(this).serialize(),
    success: function (response) {
      $("#issueBookResponse").html(response);
      loadAvailableBooks(); // Refresh available books
      $("#issueBookForm")[0].reset(); // Clear form
    },
    error: function () {
      $("#issueBookResponse").html("<p class='text-danger'>Failed to issue book. Please try again.</p>");
    }
  });

  
 // Edit Issued Book
 $(document).on("click", ".edit-issue-btn", function () {
  var bookId = $(this).data("book-id");
  var memberId = $(this).data("member-id");

  // Set selected values in the form fields
  $('#bookSelect').val(bookId);
  $('#memberSelect').val(memberId);
  $('#originalBookId').val(bookId);  // Store original book ID to use in the backend

  // Show the modal
  $('#editIssueModal').modal('show');
});

// Save changes when clicking the save button
$('#saveIssueChanges').click(function () {
  var formData = $('#editIssueForm').serialize();  // Serialize form data

  $.ajax({
      url: 'issue_book.php',
      type: 'POST',
      data: formData,
      success: function (response) {
          console.log("Edit Response:", response.trim());
          if (response.trim() === "Issue updated successfully!") {
              alert("Issue updated successfully!");

              // Optional: Reload the issued books table if necessary
              loadIssuedBooks(); // Assuming you have this function to refresh the table

              $('#editIssueModal').modal('hide');  // Hide modal after saving
          } else {
              alert("Failed to update issue: " + response);
          }
      },
      error: function(xhr, status, error) {
          console.error("AJAX Error:", status, error);
          alert("An error occurred. Please try again.");
      }
  });
});



});
$(document).ready(function() {
  console.log("Document is ready.");

  // Log to check if the delete button handler is set
  $(document).on("click", ".delete-issue-btn", function() {
      console.log("Delete button clicked");  // Log this to confirm click events are being caught

      var bookId = $(this).data("book-id");
      var memberId = $(this).data("member-id");

      if (confirm("Are you sure you want to delete this issue?")) {
          $.ajax({
              url: 'delete_issue.php',
              type: 'POST',
              data: { book_id: bookId, member_id: memberId },
              success: function(response) {
                  console.log("Delete Response:", response.trim());
                  if (response.trim() === "Issue deleted successfully!") {
                      $('#row-' + bookId + '-' + memberId).remove();
                      alert("Issue deleted successfully!");
                  } else {
                      alert("Failed to delete issue: " + response);
                  }
              },
              error: function(xhr, status, error) {
                  console.error("AJAX Error:", status, error);
                  alert("An error occurred. Please try again.");
              }
          });
      }
  });
});