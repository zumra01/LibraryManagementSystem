<?php
function make_connection() {
  $host = 'localhost';
  $db = 'librarymanagmentsystem';
  $user = 'root';
  $pass = '';

  $conn = new mysqli($host, $user, $pass, $db);

  if ($conn->connect_error) {
    echo "THERE IS AN ERROR IN DATABASE CONNECTION: " . $conn->connect_error;
  } else {
    // echo "SUCCESSFULLY CONNECTED";
  }

  return $conn;
}

make_connection();
?>

