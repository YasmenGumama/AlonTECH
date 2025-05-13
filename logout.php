<?php
session_start();
session_unset();      // Clear all session variables
session_destroy();    // Destroy the session

header("Location: index.html");  // Redirect to homepage or login page
exit();               // Ensure no further code is run
?>
