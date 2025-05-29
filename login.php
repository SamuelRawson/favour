<?php
session_start();
include("connections.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    if (empty($identifier) || empty($password)) {
        echo "Please fill in all required fields.";
        exit;
    }

   
    $query = "SELECT id, firstname, matric, email, hashed_password FROM users WHERE matric = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['hashed_password'])) {
            // Password is correct – set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['matric'] = $user['matric'];
            $_SESSION['email'] = $user['email'];

           
            // Redirect to student data page
            header("Location: student.php");
            exit;
          
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ No account found with that matric number or email.";
    }

    $stmt->close();
    $conn->close();
}
?>
