<?php
	session_start();
	
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

	include "../../conf/conf.php";

	if(isset($_POST['simpan'])) {
	
    $rrn = $_POST['rrn'];
    $mdp = $_POST['mdp'];
    $supplier = $_POST['supplier'];
    $noka = $_POST['noka'];
    $nosin = $_POST['nosin'];
    $tipe = $_POST['tipe'];
    $model = $_POST['model'];
    $suffix = $_POST['suffix'];
    $kodeWarna = $_POST['kodewarna'];
    $warna = $_POST['warna'];
    $posisi = $_POST['posisi'];
    $keterangan = $_POST['keterangan'];
    $kodeProduksi = $_POST['kodeproduksi'];
    $status = $_POST['status'];
    
    
    
    $statement = "INSERT INTO rrn_unit(
    		no_rrn,
            alokasi_mdp,
            supplier,
            noka,
            nosin,
            tipe_name,
            model_code,
            suffix,
            kode_warna,
            warna_kendaraan,
            posisi_unit,
            keterangan,
            kode_produksi,
            status_unit,
			tgl_simpan,
            user
            )VALUES(
            '".$rrn."',
            '".$mdp."',
            '".$supplier."',
            '".$noka."',
            '".$nosin."',
            '".$tipe."',
            '".$model."',
            '".$suffix."',
            '".$kodeWarna."',
            '".$warna."',
            '".$posisi."',
            '".$keterangan."',
            '".$kodeProduksi."',
            '".$status."',
            now(),
            '".$user."'
            )";
	$stmt = $conn->prepare($statement);
	$stmt->execute();

	if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
		window.location = "tampil-rrn.php";
		</script>';
		}
	}
