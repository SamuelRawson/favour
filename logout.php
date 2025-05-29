<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page (change to your login filename if needed)
header("Location: index.html");
exit;
?>
