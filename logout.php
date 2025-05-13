<?php
// logout.php
session_start();           // ① resume the session
session_unset();           // ② clear all $_SESSION variables
session_destroy();         // ③ destroy the session
header("Location: login.php"); // ④ redirect back to login page
exit;                      // ⑤ stop any further output
?>
