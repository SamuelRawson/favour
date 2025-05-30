<?php
require 'connections.php';

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
    <a class="navbar-brand" href="dashboard.php">Campus Events</a>
  </div>
</nav>

<div class="container event-container">
  <div class="card shadow p-4">
    <h2 class="mb-3"><?php echo htmlspecialchars($event['title']); ?></h2>
    <p class="text-muted mb-4">📅 <?php echo date("F j, Y", strtotime($event['create_at'])); ?></p>

    <?php if (!empty($event['image_path']) && file_exists('./admin/' . $event['image_path'])): ?>
      <img src="./admin/<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" style="width:500px;
       margin: 40px auto;" class="event-image">
    <?php endif; ?>



    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

    <a href="viewevent.php" class="btn btn-secondary mt-3">← Back to Events</a>
  </div>
</div>

<footer>
  &copy; 2025 Campus Event Management System. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
