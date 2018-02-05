<?php
	session_start();
	
if (empty($_SESSION['username'])) {
    
    echo "<script type='text/javascript'>
        window.location = '../login/login-form.php';
    </script>";
    
} else {
    $spv = $_SESSION['username'];
}

	include __DIR__ . "/../conf/conf.php";

	if(isset($_POST['daftar'])) {

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
        $tgl_masuk = $_POST['tgl_masuk'];
		
		$query = "SELECT * FROM master_karyawan WHERE username = '".$spv."'";
		$sql = $conn->prepare($query);
		$sql->execute();
		$atasan = $sql->fetchAll();
		$namaAtasan = $atasan[0]['nama'];
		$jabatanAtasan = $atasan[0]['jabatan_sekarang'];

		//echo "<pre>";
		//var_dump($jabatanAtasan);
		//exit;

		$statement = "INSERT INTO master_karyawan(
				nik,
				nama,
				alamat_ktp,
				alamat_domisili,
				no_telp,
				no_hp,
				email,
				no_rekening,
				nama_keluarga,
				alamat_keluarga,
				no_telp_keluarga,
				no_hp_keluarga,
				upload_ktp,
				upload_kk,
				jabatan_sekarang,
				tempat_sekarang,
				user_input,
				tgl_masuk,
				tgl_input
				) 
				VALUES(
				'".$ktp."', 
				'".$nama."',
				'".$alamat_ktp."',
				'".$alamat_domisili."',
				'".$telp."',
				'".$hp."',
				'".$email."',
				'".$rekening."',
				'".$nama_keluarga."',
				'".$alamat_keluarga."',
				'".$no_telp_keluarga."',
				'".$no_hp_keluarga."',
				'".$upload_ktp."',
				'".$upload_kk."',
				'".$jabatan."',
				'".$cabang."',
				'".$spv."',
				'".$tgl_masuk."',
				now()
				);INSERT INTO hirarki_karyawan(
					nama_karyawan,
					jabatan_karyawan,
				)VALUES(
					'".$nama."',
					'".$jabatan."',
				)";
				
		$stmt = $conn->prepare($statement);
		$stmt->execute();

	if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
		window.location = "daftar-karyawan.php";
		</script>';
		}
	}
