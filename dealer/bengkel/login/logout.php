 <?php
 session_start();
 session_destroy();
 echo 'You have been logged out. <a href="login-form.php">Go back</a>';
