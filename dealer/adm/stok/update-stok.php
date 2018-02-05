<?php
	session_start();
	
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

	include "../conf/conf.php";

	if(isset($_POST['update'])) {
    
   		$id = $_POST['id'];
		$rrn = $_POST['rrn'];
    	$cabang = $_POST['cabang'];
    	$noka = $_POST['noka'];
    	$nosin = $_POST['nosin'];
    	$supplier = $_POST['supplier'];
    	$warna = $_POST['warna'];
    	$model = $_POST['model'];
    	$tipe = $_POST['tipe'];
    		
        $update = "UPDATE stok_unit 
			SET no_rrn='".$rrn."',
            	cabang='".$cabang."',
                noka='".$noka."',
                nosin='".$nosin."',
                supplier='".$supplier."',
                warna_unit='".$warna."',
                model_unit='".$model."',
                tipe_unit='".$tipe."',
                tgl_update=now(),
                user='".$user."'
				WHERE id='".$id."'";
			
			$stmt = $conn->prepare($update);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo "<script type='text/javascript'>
					window.location = 'tampil-stok.php';
					</script>";
			}
        } /*elseif (isset($_POST['hapus'])) {
		$id = $_POST['id'];

		$statement = "UPDATE stok_unit SET hapus=1 WHERE id='".$id."'";
		$stmt = $conn->prepare($statement);
		$stmt->execute();

	} */
