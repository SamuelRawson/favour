<?php
session_start();
include("connections.php");

// Redirect if admin is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get admin name if available
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Admin';

// Handle delete request
if (isset($_GET['delete'])) {
    $event_id = intval($_GET['delete']); // Sanitize input
    if ($event_id > 0) {
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: manageevnt.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM events ORDER BY id DESC");
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
      <span class="navbar-brand">Campus Event Management - Manage Event</span>
    </div>
  </nav>

  <!-- Main Dashboard Content -->
  <div class="main-content">
     <div class="container mt-5">
  <h2 class="mb-4">Manage Event</h2>

  <table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Passcode</th>
      <th>Date</th>
      <th>End Time</th>
      <th>Venue</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($event = $result->fetch_assoc()): ?>
      <tr onclick="window.location.href='event-detail.php?id=<?= $event['id'] ?>'" style="cursor: pointer;">
        <td><?= $event['id'] ?></td>
        <td><?= htmlspecialchars($event['title']) ?></td>
        <td><?= htmlspecialchars($event['passcode']) ?></td>
        <td><?= htmlspecialchars($event['event_date']) ?></td>
        <td><?= htmlspecialchars($event['end_time']) ?></td>
        <td><?= htmlspecialchars($event['venue']) ?></td>
        <td>
          <a href="edit-event.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="manageevent.php?delete=<?= $event['id'] ?>" class="btn btn-sm btn-danger"
             onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>


</div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>