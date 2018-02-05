<?php
	session_start();
	
if (empty($_SESSION['username']) && ($modul == 'driver')) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

	include __DIR__ . "/../conf/conf.php";

	if (isset($_POST['setuju'])) {

		$id = $_POST['id'];
		$user = $_SESSION['username'];

		$approve = "UPDATE sales_unit_kirim 
		SET approve_driver=1,
		driver ='".$user."',
		user='".$user."'
		WHERE id='".$id."'";

		$stmt = $conn->prepare($approve);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			echo "<script type='text/javascript'>
			window.location = 'detail-unit.php?id=".$id."';
			</script>";
		}
	} elseif (isset($_POST['batal'])) {

			$id = $_POST['id'];
			$user = $_SESSION['username'];

			$approve = "UPDATE sales_unit_kirim 
			SET approve_driver=0,
            driver='Driver',
			user='".$user."'
			WHERE id='".$id."'";

			$stmt = $conn->prepare($approve);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo '<script type="text/javascript">
				window.location = "tampil.php";
				</script>';
		}
	} 
