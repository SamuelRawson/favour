<?php
require 'connections.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid event ID.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Event not found.");
}

$event = $result->fetch_assoc();

$join_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passcode'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $entered_passcode = trim($_POST['passcode']);
    $user_id = $_SESSION['user_id'];

    if ($entered_passcode === $event['passcode']) {
        // Check if already joined
        $check_stmt = $conn->prepare("SELECT * FROM attendance WHERE user_id = ? AND event_id = ?");
        $check_stmt->bind_param("ii", $user_id, $id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows === 0) {
            // Insert attendance
            $insert_stmt = $conn->prepare("INSERT INTO attendance (user_id, event_id, attended_at) VALUES (?, ?, NOW())");
            $insert_stmt->bind_param("ii", $user_id, $id);
            if ($insert_stmt->execute()) {
                $join_message = "✅ Successfully joined the event.";
            } else {
                $join_message = "❌ Failed to record attendance.";
            }
        } else {
            $join_message = "ℹ️ You have already joined this event.";
        }
    } else {
        $join_message = "❌ Incorrect passcode.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($event['title']); ?> - Event Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background-color: #003366;
    }
    .navbar-brand, .nav-link, .btn-outline-light {
      font-weight: 500;
    }
    .event-container {
      margin-top: 40px;
      margin-bottom: 60px;
    }
    .event-image {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    footer {
      margin-top: 50px;
      padding: 20px;
      background-color: #003366;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="student.php">Campus Events</a>
  </div>
</nav>

<div class="container event-container">
  <div class="card shadow p-4">
    <h2 class="mb-3"><?php echo htmlspecialchars($event['title']); ?></h2>
    <p class="text-muted mb-4">📅 <?php echo date("F j, Y", strtotime($event['create_at'])); ?></p>

    <?php if (!empty($event['image_path']) && file_exists('./admin/' . $event['image_path'])): ?>
      <img src="./admin/<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" style="width:500px; margin: 40px auto;" class="event-image">
    <?php endif; ?>

    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

    <?php if (!empty($join_message)): ?>
      <div class="alert alert-info mt-3"><?php echo $join_message; ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
  <form method="post" action="submitattendance.php" class="mt-4">
    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
    <div class="mb-3">
      <label for="passcode" class="form-label">Enter Event Passcode to Join:</label>
      <input type="text" class="form-control" name="passcode" id="passcode" required>
    </div>
    <button type="submit" class="btn btn-primary">Join Event</button>
  </form>
<?php
$join_message = "";
if (isset($_GET['status'])) {
  switch ($_GET['status']) {
    case "success":
      $join_message = "✅ Successfully joined the event.";
      break;
    case "fail":
      $join_message = "❌ Failed to record attendance.";
      break;
    case "invalid":
      $join_message = "❌ Incorrect passcode.";
      break;
  }
}
?>

  <?php else: ?>

      <p class="text-warning mt-4">Please <a href="login.php">log in</a> to join this event.</p>
    <?php endif; ?>

    <a href="viewevent.php" class="btn btn-secondary mt-4">← Back to Events</a>
  </div>
</div>

<footer>
  &copy; 2025 Campus Event Management System. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
