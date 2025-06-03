<?php
require 'connections.php';
session_start();

// Check if event ID is passed
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Event ID");
}

$event_id = intval($_GET['id']);

// Get event details
$event_stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$event_stmt->bind_param("i", $event_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();

if ($event_result->num_rows === 0) {
    die("Event not found.");
}

$event = $event_result->fetch_assoc();

// Get attendees
$attendees_stmt = $conn->prepare("SELECT name, matric, attended_at FROM attendance WHERE event_id = ?");
$attendees_stmt->bind_param("i", $event_id);
$attendees_stmt->execute();
$attendees_result = $attendees_stmt->get_result();
$attendee_count = $attendees_result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | Campus Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f1f3f5;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      position: fixed;
      width: 250px;
      background-color: #003366;
      padding-top: 20px;
      color: white;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      display: block;
      transition: 0.3s;
    }

    .sidebar a:hover, .sidebar a.active {
      background-color: #004080;
      border-left: 5px solid #00bfff;
    }

    .main-content {
      margin-left: 250px;
      padding: 20px;
    }

    .navbar {
      margin-left: 250px;
      background-color: white;
      border-bottom: 1px solid #ddd;
    }

    .card {
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>

  <!-- Sidebar Navigation -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="dashboard.php" >Dashboard</a>
    <a href="manageuser.php" >Manage users</a>
    <a href="manageevent.php" class="active">Manage Events</a>
    <a href="createevent.html">Create Event</a>
    <a href="#">Settings</a>
    <a href="logout.php">Logout</a>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand">Campus Event Management - Admin</span>
    </div>
  </nav>

  <!-- Main Dashboard Content -->

  <div class="main-content">
     <div class="container mt-5">
  <h2 class="mb-4">Manage Registered Users</h2>
  <h2 class="mb-3"><?php echo htmlspecialchars($event['title']); ?></h2>
  <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
  <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
  <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

  <hr>
  <h4>Attendees (<?php echo $attendee_count; ?>)</h4>

  <?php if ($attendee_count > 0): ?>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Matric No.</th>
          <th>Time Joined</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $attendees_result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['matric']); ?></td>
            <td><?php echo date("F j, Y - h:i A", strtotime($row['attended_at'])); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No one has joined this event yet.</p>
  <?php endif; ?>

  <a href="dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>
</div>
</body>
</html>
