<?php

include __DIR__ . '/../conf/conf.php';

if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
        $sqlLogin = "SELECT *
    FROM master_login
    WHERE username = '".$user."'";

$stmt = $conn->prepare($sqlLogin);
$stmt->execute();
$dataLogin = $stmt->fetchAll();
$modul = $dataLogin[0]['modul'];
}

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="<?php echo homeUrl; ?>asset/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo homeUrl; ?>asset/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo homeUrl; ?>asset/bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo homeUrl; ?>asset/css/jquery.simple-dtpicker.css">
<script src="<?php echo homeUrl; ?>asset/js/jquery.validate.min.js"></script>
<script src="<?php echo homeUrl; ?>asset/js/jquery.simple-dtpicker.js"></script>

<div class="navbar navbar-fixed-top">
<div class="navbar-inner">

<?php if (!empty($_SESSION['username'])) { ?>
  <a class="brand" href="#">
<?php echo $_SESSION['username']; } ?>
</a>

    <ul class="nav">
      <?php
      if(!empty($_SESSION['username'])) {
          if(($modul == 'kepala_cabang') || ($modul == 'gm')) {
                echo "<li><a href='report.php'>Report</a></li>";
          }
              echo "</ul>";
              echo "<ul class='nav pull-right'>";
          echo "<li><a href='".homeUrl."dealer/user/password/form-proses/ganti.php'>Ganti Password</a></li>";
                  echo "<li><a href='".homeUrl."dealer/user/login/form-proses/logout.php'>Logout</a></li>";
                } else {
                  echo "</ul>";
                  echo "<ul class='nav pull-right'>";
                  echo "<li><a href='".homeUrl."dealer/user/login/form/login.php'>Login</a></li>";
                } ?>
          </ul>
          </div>
        </div>
        <legend>
                <br>
        </legend>
