<?php
date_default_timezone_set('Asia/Jakarta');
$server = "localhost";
$username = "root";
$password = "l13km0t0r";
$database = "dealer";

mysql_connect($server,$username,$password);
mysql_select_db($database);

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

function cek_session_admin(){
        $level = $_SESSION[level];
        /*if ($level != 'superuser'){
                echo "<script>document.location='index.php';</script>";
        }*/
}
?>
