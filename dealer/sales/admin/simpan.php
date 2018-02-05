<?php
/*
	session_start();
	
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $spv = $_SESSION['username'];
}

	include '../../conf/conf.php';
*/
include __DIR__ . "/../head.php";

	if(isset($_POST['simpan'])) {

		$jam = $_POST['jam'];
		$spk = $_POST['spk'];
		$alamat = $_POST['alamat'];
		$kota = $_POST['kota'];
		$driver = $_POST['optionsRadios'];
		$telp = $_POST['telp'];
		$noka = $_POST['noka'];
		$tipe = $_POST['tipe'];
		$variasi = $_POST['variasi'];
		$spv = $_SESSION['username'];
		
		$statement = "INSERT INTO sales_unit_kirim(
				jam_kirim, 
				driver,
				nomor_spk, 
				alamat, 
				kota,
				nomor_telp, 
				spv, 
				noka, 
				type_warna, 
				variasi, 
				tgl_simpan, 
				tgl_update, 
				user) 
				VALUES(
				'".$jam."', 
				'".$driver."',
				'".$spk."',
				'".$alamat."',
				'".$kota."',
				'".$telp."',
				'".$spv."',
				'".$noka."',
				'".$tipe."',
				'".$variasi."',
				now(),
				now(),
				'".$spv."'
				)";
		$stmt = $conn->prepare($statement);
		$stmt->execute();

		if($stmt->rowCount() > 0) {
			echo '<script type="text/javascript">
			window.location = "tampil.php";
			</script>';
		}
	}
