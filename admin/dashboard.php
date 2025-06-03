<?php
session_start();
include("connections.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'] ?? 'Admin';

// Get counts
$total_users_result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$total_events_result = $conn->query("SELECT COUNT(*) AS total_events FROM events");

$total_users = $total_users_result->fetch_assoc()['total_users'];
$total_events = $total_events_result->fetch_assoc()['total_events'];

// Get recent 5 events
$recent_events = $conn->query("
    SELECT 
        e.id, e.title, e.event_date, e.venue,
        (SELECT COUNT(*) FROM attendance WHERE event_id = e.id) AS attendees
    FROM events e
    ORDER BY e.event_date DESC
    LIMIT 5
");
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
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="manageuser.php" >Manage users</a>
    <a  href="manageevent.php">Manage Events</a>
    <a href="createevent.html">Create Event</a>
    <a href="#">Settings</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Top Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand">Campus Event Management - Admin</span>
    </div>
  </nav>

  <!-- Main Dashboard Content -->
    <div class="main-content">
  <h3>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h3>
  <p class="text-muted">Here's an overview of the platform.</p>

  <div class="row g-4 mt-3">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Total Events</h5>
          <p class="card-text display-6 fw-bold text-primary"><?= $total_events ?></p>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Registered Users</h5>
          <p class="card-text display-6 fw-bold text-success"><?= $total_users ?></p>
        </div>
      </div>
    </div>
    
  <!-- Recent Events Table -->
  <div class="mt-5">
    <h5 class="mb-3">Recent Events</h5>
    <div class="table-responsive">
      <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-light">
          <tr>
            <th>Event Title</th>
            <th>Date</th>
            <th>Venue</th>
            <th>Attendees</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($event = $recent_events->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($event['title']) ?></td>
              <td><?= htmlspecialchars(date("M d, Y", strtotime($event['event_date']))) ?></td>
              <td><?= htmlspecialchars($event['venue']) ?></td>
              <td><?= $event['attendees'] ?></td>
              <td>
                <?php
                  $status = (strtotime($event['event_date']) > time()) ? 'Upcoming' : 'Active';
                  $badge = $status === 'Upcoming' ? 'warning text-dark' : 'success';
                ?>
                <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
