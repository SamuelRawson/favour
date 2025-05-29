<?php
session_start();
include("connections.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize inputs
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $matric = trim($_POST['matric']);
    $department = trim($_POST['department']);
    $faculty = trim($_POST['faculty']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($firstname) || empty($lastname) || empty($matric) || empty($email) || empty($password)) {
        echo "All required fields must be filled.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if matric or email already exists
    $check_query = "SELECT id FROM users WHERE matric = ? OR email = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ss", $matric, $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Matric number or email already registered.";
        $check_stmt->close();
        $conn->close();
        exit;
    }
    $check_stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $insert_query = "INSERT INTO users (firstname, middlename, lastname, matric, department, faculty, email, phone, hashed_password) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sssssssss", $firstname, $middlename, $lastname, $matric, $department, $faculty, $email, $phone, $hashed_password);

    if ($insert_stmt->execute()) {
        echo "✅ Registration successful! <a href='login.html'>Click here to login</a>";
    } else {
        echo "❌ Error: Could not register. Please try again later.";
    }

    $insert_stmt->close();
    $conn->close();
}
?>
