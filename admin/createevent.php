<?php
include("connections.php");

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $venue = trim($_POST['venue']);

    // Handle Image Upload
    $targetDir = "uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Allow certain file formats
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    if (!in_array($imageFileType, $allowedTypes)) {
        die("Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, venue, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $date, $venue, $targetFilePath);

        if ($stmt->execute()) {
            echo "<div style='padding:20px; text-align:center;'><h3>✅ Event Created Successfully!</h3><a href='dashboard.html'>Back to Dashboard</a></div>";
        } else {
            echo "Database Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ Failed to upload image.";
    }

    $conn->close();
}
?>
