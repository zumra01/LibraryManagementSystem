<?php
include 'db_config.php';
$conn = make_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $gender = $_POST['gender'];

    // Handle file upload
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $targetDir = "images/";
        $photoPath = $targetDir . basename($_FILES["photo"]["name"]);
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {
            echo "Error uploading photo!";
            exit;
        }
    }

    // Insert member data into the database
    $sql = "INSERT INTO members (name, email, phone_number, gender, photo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone_number, $gender, $photoPath);

    if ($stmt->execute()) {
        echo "<script>alert('New member added successfully!');</script>";
        } else {
        echo "Error adding member: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();

?>

