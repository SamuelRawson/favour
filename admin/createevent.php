<?php
include("connections.php");

function generateUniquePasscode($conn) {
    do {
        $passcode = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6)); // 6-character unique code
        $check = $conn->prepare("SELECT id FROM events WHERE passcode = ?");
        $check->bind_param("s", $passcode);
        $check->execute();
        $check->store_result();
    } while ($check->num_rows > 0);
    $check->close();
    return $passcode;
}

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $end_time = $_POST['end_time'];  // new field
    $venue = trim($_POST['venue']);

    // Generate unique passcode
    $passcode = generateUniquePasscode($conn);

    // Handle Image Upload
    $targetDir = "uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        die("Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, end_time, venue, image_path, passcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $title, $description, $date, $end_time, $venue, $targetFilePath, $passcode);

        if ($stmt->execute()) {
            echo "<script>
            alert('✅ Event Created Successfully!\\nPasscode: $passcode');
            window.location.href = 'dashboard.html';
            </script>";

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
