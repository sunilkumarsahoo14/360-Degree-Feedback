<?php
session_start();
session_destroy();
header("Location: ../login_form.php"); // Redirect to login page
exit();
?>
