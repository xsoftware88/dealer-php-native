<?php
	session_start();
	
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login/login-form.php";
    </script>
    <?php
} else {
    $spv = $_SESSION['username'];
}

	include __DIR__ . "/../../conf/conf.php";

	if(isset($_POST['update'])) {
		
    	$id = $_POST['id'];
		$ktp = $_POST['ktp'];
		$nama = $_POST['nama'];
		$alamat_ktp = $_POST['alamat_ktp'];
		$alamat_domisili = $_POST['alamat_domisili'];
		$telp = $_POST['telp'];
		$hp = $_POST['hp'];
		$email = $_POST['email'];
		$rekening = $_POST['rekening'];
		$nama_keluarga = $_POST['nama_keluarga'];
		$alamat_keluarga = $_POST['alamat_keluarga'];
		$no_telp_keluarga = $_POST['no_telp_keluarga'];
		$no_hp_keluarga = $_POST['no_hp_keluarga'];
		$upload_ktp = $_POST['upload_ktp'];
		$upload_kk = $_POST['upload_kk'];
		$jabatan = $_POST['jabatan'];
		$cabang = $_SESSION['cabang'];
		
		$query = "SELECT * FROM master_karyawan WHERE username = '".$spv."'";
		$sql = $conn->prepare($query);
		$sql->execute();
		$atasan = $sql->fetchAll();
		$namaAtasan = $atasan[0]['nama'];
		$jabatanAtasan = $atasan[0]['jabatan_sekarang'];

		echo "<pre>";

		$statement = "UPDATE master_karyawan,hirarki_karyawan
				SET 
                master_karyawan.nik='".$ktp."',
				master_karyawan.nama='".$nama."',
                hirarki_karyawan.nama_karyawan='".$nama."',
				master_karyawan.alamat_ktp='".$alamat_ktp."',
				master_karyawan.alamat_domisili='".$alamat_domisili."',
				master_karyawan.no_telp='".$telp."',
				master_karyawan.no_hp='".$hp."',
				master_karyawan.email='".$email."',
				master_karyawan.no_rekening='".$rekening."',
				master_karyawan.nama_keluarga='".$nama_keluarga."',
				master_karyawan.alamat_keluarga='".$alamat_keluarga."',
				master_karyawan.no_telp_keluarga='".$no_telp_keluarga."',
				master_karyawan.no_hp_keluarga='".$no_hp_keluarga."',
				master_karyawan.upload_ktp='".$upload_ktp."',
				master_karyawan.upload_kk='".$upload_kk."',
				master_karyawan.jabatan_sekarang='".$jabatan."',
                hirarki_karyawan.jabatan_karyawan='".$jabatan."',
				master_karyawan.tempat_sekarang='".$cabang."',
				master_karyawan.user_input='".$spv."',
				master_karyawan.tgl_masuk=now(),
				master_karyawan.tgl_update=now()
                WHERE master_karyawan.id='".$id."'
                AND master_karyawan.nama=hirarki_karyawan.nama_karyawan";
		//var_dump($_POST);
		//exit;
    
		$stmt = $conn->prepare($statement);
		$stmt->execute();
    
		if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
			window.location = "report.php";
		</script>';
		} else {
			echo '<script type="text/javascript">
				window.location = "report.php";
			</script>';
    	}
	} else if (isset($_POST['nonaktif'])) {

			$id = $_POST['id'];

			$statement = "UPDATE master_karyawan
				SET active=0,
      			jabatan_terakhir='".$dataEdit['jabatan_sekarang']."',
      			tempat_terakhir='".$dataEdit['tempat_sekarang']."',
     			tgl_keluar=now(),
      			tgl_update=now()
				WHERE id='".$id."'";

			$stmt = $conn->prepare($statement);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo '<script type="text/javascript">
					window.location = "report.php";
				</script>';
			}
	} 
