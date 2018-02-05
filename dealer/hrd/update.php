<?php
	session_start();
	
if (empty($_SESSION['username'])) {
    
    echo "<script type='text/javascript'>
        window.location = '../login/login-form.php';
    </script>";
    
} else {
    $spv = $_SESSION['username'];
}

	include "../../conf/conf.php";

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
		
		$query = "SELECT * FROM master_karyawan WHERE username = '".$spv."'";
		$sql = $conn->prepare($query);
		$sql->execute();
		$atasan = $sql->fetchAll();
		$namaAtasan = $atasan[0]['nama'];
		$jabatanAtasan = $atasan[0]['jabatan_sekarang'];

		//echo "<pre>";
		//var_dump($jabatanAtasan);
		//exit;

		$statement = "UPDATE master_karyawan
				SET nik='".$ktp."',
				nama='".$nama."',
				alamat_ktp='".$alamat_ktp."',
				alamat_domisili='".$alamat_domisili."',
				no_telp='".$telp."',
				no_hp='".$hp."',
				email='".$email."',
				no_rekening='".$rekening."',
				nama_keluarga='".$nama_keluarga."',
				alamat_keluarga='".$alamat_keluarga."',
				no_telp_keluarga='".$no_telp_keluarga."',
				no_hp_keluarga='".$no_hp_keluarga."',
				upload_ktp='".$upload_ktp."',
				upload_kk='".$upload_kk."',
				jabatan_sekarang='".$jabatan."',
				tempat_sekarang='".$cabang."',
				user_input='".$spv."',
				tgl_masuk=now(),
				tgl_input=now();
				UPDATE hirarki_karyawan
					SET nama_karyawan='".$nama."',
					jabatan_karyawan='".$jabatan."'";
				
		$stmt = $conn->prepare($statement);
		$stmt->execute();

	if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
		window.location = "daftar.php";
		</script>';
		}
	}
