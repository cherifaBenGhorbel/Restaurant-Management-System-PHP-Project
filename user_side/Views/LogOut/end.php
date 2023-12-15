<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
header('Location: ../welcome/welcome.php');
exit();
?>
