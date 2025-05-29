<?php
session_start();
require 'connections.php';

// Pagination setup
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total events
$total_result = $conn->query("SELECT COUNT(*) AS total FROM events");
$total_row = $total_result->fetch_assoc();
$total_events = $total_row['total'];
$total_pages = ceil($total_events / $limit);

// Fetch paginated events
$stmt = $conn->prepare("SELECT * FROM events ORDER BY create_at DESC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$events_result = $stmt->get_result();
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
            <a class="nav-link" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="viewevent.php">View Event</a>
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

    <!-- Dynamic Events -->
    <div class="row">
      <?php if ($events_result->num_rows > 0): ?>
        <?php while ($event = $events_result->fetch_assoc()): ?>
          <div class="col-md-4 mb-4">
            <div class="card p-3">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                <p class="event-date">📅 <?php echo date("F j, Y", strtotime($event['create_at'])); ?></p>
                <p class="card-text">
            <?php
              $description = strip_tags($event['description']); // Remove HTML tags
              $words = preg_split('/\s+/', $description); // Split into words safely

              if (count($words) > 20) {
                  $short_description = implode(' ', array_slice($words, 0, 20)) . '...';
              } else {
                  $short_description = $description;
              }

              echo htmlspecialchars($short_description, ENT_QUOTES, 'UTF-8');
            ?>
          </p>

                <a href="event-details.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center text-muted">No events found.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      <nav>
        <ul class="pagination">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
              <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
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
