<?php
/*session_start();
	
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

	include __DIR__ . "/../conf/conf.php";
*/

include __DIR__ . "/../head.php";

	if (isset($_POST['setuju'])) {

		$id = $_POST['id'];
		$user = $_SESSION['username'];
        $ket = $_POST['keterangan'];

		$approve = "UPDATE sales_unit_kirim 
		SET approve_pdc=1,
		pdc='".$user."',
        keterangan='".$ket."',
		user='".$user."'
		WHERE id='".$id."'";

		$stmt = $conn->prepare($approve);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			echo '<script type="text/javascript">
			window.location = "index.php";
			</script>';
		}
	} elseif (isset($_POST['batal'])) {

			$id = $_POST['id'];
			$user = $_SESSION['username'];
            $ket = $_POST['keterangan'];

			$approve = "UPDATE sales_unit_kirim 
			SET approve_pdc=0,
            pdc='".$user."',
            keterangan='".$ket."',
			user='".$user."'
			WHERE id='".$id."'";

			$stmt = $conn->prepare($approve);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo '<script type="text/javascript">
				window.location = "index.php";
				</script>';
		}
	}
