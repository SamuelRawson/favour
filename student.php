<?php
session_start();

// Redirect to login if neither email nor matric is set in the session
if (!isset($_SESSION['email']) && !isset($_SESSION['matric'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Campus Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
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

    .dashboard-header {
      margin-top: 30px;
      margin-bottom: 20px;
      text-align: center;
    }

    .card {
      border: none;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .card h5 {
      font-weight: 600;
    }

    .event-date {
      font-size: 0.9rem;
      color: #666;
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

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">Campus Events</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3">
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewevent.php">View Event</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="manage-events.php">Manage Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
        </ul>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Dashboard Header -->
  <div class="container">
    <div class="dashboard-header">
      <h2>Welcome to Your Dashboard</h2>
      <p class="text-muted">Here are your upcoming events</p>
    </div>

    <div class="row">
      <!-- Example Event Card 1 -->
      <div class="col-md-4 mb-4">
        <div class="card p-3">
          <div class="card-body">
            <h5 class="card-title">Tech Conference 2025</h5>
            <p class="event-date">📅 May 25, 2025</p>
            <p class="card-text">Join top developers and innovators in this annual technology gathering.</p>
            <a href="event-details.php?id=1" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Example Event Card 2 -->
      <div class="col-md-4 mb-4">
        <div class="card p-3">
          <div class="card-body">
            <h5 class="card-title">Campus Music Night</h5>
            <p class="event-date">🎶 June 10, 2025</p>
            <p class="card-text">An evening of performances by student bands and artists. Don’t miss it!</p>
            <a href="event-details.php?id=2" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Example Event Card 3 -->
      <div class="col-md-4 mb-4">
        <div class="card p-3">
          <div class="card-body">
            <h5 class="card-title">Innovation Fair</h5>
            <p class="event-date">🧠 July 15, 2025</p>
            <p class="card-text">Showcase of student projects and startups across campus faculties.</p>
            <a href="event-details.php?id=3" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2025 Campus Event Management System. All rights reserved.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
