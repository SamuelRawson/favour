<?php
include("connections.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'], $_POST['passcode'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = intval($_POST['event_id']);
    $passcode = trim($_POST['passcode']);

    // Verify event and get title
    $check = $conn->prepare("SELECT title FROM events WHERE id = ? AND passcode = ?");
    $check->bind_param("is", $event_id, $passcode);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 1) {
        $event = $result->fetch_assoc();
        $event_title = $event['title'];

        // Get user info
        $user_query = $conn->prepare("SELECT firstname, middlename, lastname, matric FROM users WHERE id = ?");
        $user_query->bind_param("i", $user_id);
        $user_query->execute();
        $user_result = $user_query->get_result();
        $user = $user_result->fetch_assoc();

        $name = $user['firstname'] . " " . $user['middlename'] . " " . $user['lastname'];
        $matric = $user['matric'];

        // Record attendance
        $insert = $conn->prepare("INSERT IGNORE INTO attendance (event_id, event_title, user_id, name, matric) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("isiss", $event_id, $event_title, $user_id, $name, $matric);

        if ($insert->execute()) {
            echo "<script>
            alert('✅ Event Successfully!');
            window.location.href = 'dashboard.html';
            </script>";
        } else {
            echo "❌ Error recording attendance: " . $insert->error;
        }

        $insert->close();
    } else {
        echo "❌ Invalid passcode or event not found.";
    }

    $check->close();
    $conn->close();
}
?>
