 <?php
 session_start();
 include __DIR__ . '/../../../conf/conf.php';
 session_destroy();
 echo 'You have been logged out. <a href="'.homeUrl.'dealer/">Go back</a>';
