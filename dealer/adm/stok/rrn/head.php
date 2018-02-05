<?php

	include __DIR__ . '/../../conf/conf.php';

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
	<script src="../../asset/js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../../asset/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../asset/bootstrap/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/css/jquery.simple-dtpicker.css">
	<script src="../../asset/js/jquery.validate.min.js"></script>
	<script src="../../asset/js/jquery.simple-dtpicker.js"></script>

	<div class="navbar navbar-fixed-top">
  	<div class="navbar-inner">

  	<?php if (!empty($_SESSION['username'])) {  
  		?>
  	<a class="brand" href="#">
  	<?php
  	echo $_SESSION['username'];
  		}
  	?>
  	</a>

    <ul class="nav">
      <?php 
      if(!empty($_SESSION['username'])) {
      		echo "<li><a href='../tampil-stok.php'>Stok</a></li>";
      		echo "<li><a href='tampil-rrn.php'>Tampilkan RRN</a></li>";
      		echo "<li><a href='input-rrn.php'>Tambah RRN</a></li>";
	      	echo "</ul>";
	      	echo "<ul class='nav pull-right'>";
          	echo "<li><a href='../../login/password/form/ganti.php'>Ganti Password</a></li>";
	  	  	echo "<li><a href='../../login/logout.php'>Logout</a></li>";
	  	} else {
	  	  	echo "<ul class='nav pull-right'>";
	  	  	echo "<li><a href='../../login/login-form.php'>Login</a></li>";
      		echo "</ul>";
  		} ?>
	  </ul>
	  </div>
	</div>
	<legend>
		<br>
	</legend>
