<?php
session_start();
include("connections.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT firstname,middlename, lastname, matric, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update profile
$update_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = trim($_POST['firstname']);
    $middelname = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $new_email = trim($_POST['email']);

    if (empty($new_name) || empty($new_email)) {
        $update_message = "❗ All fields are required.";
    } else {
        $update_query = "UPDATE users SET firstname = ?, middlename = ?, lastname = ?,email = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssi", $new_name,$middelname, $lastname, $new_email, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['first_name'] = $new_name;
            $_SESSION['middlename'] = $middlename;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $new_email;
            $update_message = "✅ Profile updated successfully!";
            $user['firstname'] = $new_name;
            $user['middlename'] = $middlename;
            $user['lastname'] = $lastname;
            $user['email'] = $new_email;
        } else {
            $update_message = "❌ Failed to update profile.";
        }
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
          
        }
         .navbar {
      background-color: #003366;
    }

    .navbar-brand, .nav-link, .btn-outline-light {
      font-weight: 500;
    }

        .profile-container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 10px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
     <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="dashboard.html">Campus Events</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav me-3">
          <li class="nav-item">
            <a class="nav-link active" href="student.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewevent.php">View Event</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
        </ul>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['firstname']); ?></h2>

        <?php if (!empty($update_message)): ?>
            <p class="message"><?php echo $update_message; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            <label for="middlename">Full Name</label>
            <input type="text" name="middlename" value="<?php echo htmlspecialchars($user['middlename']); ?>" required>
            <label for="lastname">Full Name</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

            <label for="email">Email Address</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Matric Number</label>
            <input type="text" value="<?php echo htmlspecialchars($user['matric']); ?>" disabled>

            <button type="submit">Update Profile</button>
        </form>
        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
