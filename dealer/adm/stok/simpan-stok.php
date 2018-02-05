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

	if(isset($_POST['simpan'])) {
	
    $rrn = $_POST['rrn'];
    $cabang = $_POST['cabang'];
    $noka = $_POST['noka'];
    $nosin = $_POST['nosin'];
    $supplier = $_POST['supplier'];
    $warna = $_POST['warna'];
    $model = $_POST['model'];
    $tipe = $_POST['tipe'];
    
    $statement = "INSERT INTO stok_unit(
    		no_rrn,
            cabang,
            noka,
            nosin,
            supplier,
            warna_unit,
            model_unit,
            tipe_unit,
            tgl_simpan,
            user
            )VALUES(
            '".$rrn."',
            '".$cabang."',
            '".$noka."',
            '".$nosin."',
            '".$supplier."',
            '".$warna."',
            '".$model."',
            '".$tipe."',
            now(),
            '".$user."'
            )";
	$stmt = $conn->prepare($statement);
	$stmt->execute();

	if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
		window.location = "tampil-stok.php";
		</script>';
		}
	}
