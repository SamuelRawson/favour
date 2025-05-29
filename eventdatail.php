<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Details - Campus Events</title>
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

    .navbar-brand {
      font-weight: bold;
      font-size: 1.5rem;
    }

    .event-header {
      background: url('images/event-banner.jpg') center/cover no-repeat;
      height: 250px;
      position: relative;
      color: white;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
    }

    .event-header h1 {
      position: absolute;
      bottom: 20px;
      left: 30px;
      font-size: 2.5rem;
    }

    .event-details {
      margin-top: 40px;
    }

    .event-info p {
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .register-btn {
      margin-top: 30px;
    }

    footer {
      margin-top: 60px;
      background-color: #003366;
      color: white;
      text-align: center;
      padding: 20px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="dashboard.html">Campus Events</a>
      <div>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Event Header Banner -->
  <div class="event-header">
    <h1>Tech Conference 2025</h1>
  </div>

  <!-- Event Details Section -->
  <div class="container event-details">
    <div class="row">
      <div class="col-md-8">
        <h3>Event Overview</h3>
        <p>
          The Tech Conference 2025 brings together students, industry leaders, and innovators to explore the latest trends in technology, AI, software development, cybersecurity, and more.
        </p>

        <h4 class="mt-4">What to Expect</h4>
        <ul>
          <li>Keynote speeches from top tech executives</li>
          <li>Hands-on workshops</li>
          <li>Networking sessions</li>
          <li>Project showcases by students</li>
        </ul>

        <div class="register-btn">
          <a href="#" class="btn btn-primary btn-lg">Register for This Event</a>
        </div>
      </div>

      <div class="col-md-4 event-info">
        <div class="card shadow p-3">
          <h5 class="mb-3">📍 Event Information</h5>
          <p><strong>Date:</strong> May 25, 2025</p>
          <p><strong>Time:</strong> 10:00 AM – 4:00 PM</p>
          <p><strong>Venue:</strong> Main Auditorium, University Campus</p>
          <p><strong>Organizer:</strong> Tech Students Association</p>
          <p><strong>Contact:</strong> events@campus.edu.ng</p>
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
