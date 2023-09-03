<?php
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page with an alert message
header("Location: login.php?logout=true");
exit();
?>
