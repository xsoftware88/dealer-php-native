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

	if(isset($_POST['update'])) {
    
   		$id = $_POST['id'];
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

    		
        $update = "UPDATE stok_unit 
			SET no_rrn='".$rrn."',
            	alokasi_mdp='".$mdp."',
                supplier='".$supplier."',
                noka='".$noka."',
                nosin='".$nosin."',
                tipe_name='".$tipe."',
                model_code='".$model."',
                suffix='".$suffix."',
                kode_warna='".$kodeWarna."',
                warna_kendaraan='".$warna."',
                posisi_unit='".$posisi."',
                keterangan='".$keterangan."',
                kode_produksi='".$kodeProduksi."',
                status_unit='".$status."',
                tgl_update=now(),
                user='".$user."'
				WHERE id='".$id."'";
			
			$stmt = $conn->prepare($update);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo "<script type='text/javascript'>
					window.location = 'tampil-rrn.php';
					</script>";
			}
        } /* elseif (isset($_POST['hapus'])) {
		$id = $_POST['id'];

		$statement = "UPDATE rrn_unit SET hapus=1 WHERE id='".$id."'";
		$stmt = $conn->prepare($statement);
		$stmt->execute();

	} */
