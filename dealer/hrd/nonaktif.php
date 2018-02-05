<?php 
session_start();

include "../login/head.php";

if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}
	if (isset($_GET['id']) && !empty($_GET['id'])) {

    $cariID = $_GET['id'];
    
    $sql    = "SELECT * FROM master_karyawan WHERE id='".$cariID."'";
    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();
?>

<div class="container-fluid">
	<form class="form-horizontal" action="" method="POST">
  <div class="control-group">
    <div class="controls">
      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
      <?php 
      if ($dataEdit['active'] == 1) {
      ?>
      <input type="submit" class="btn btn-danger" value="Nonaktif" name="nonaktif">
      <?php 
      } else {
      ?>
      <input type="submit" class="btn btn-Success" value="Aktif" name="aktif">
    <?php
    }
      ?>
    </div>
  </div>
</form>
</div>

<?php
} else {
	//
}  
		if (isset($_POST['nonaktif'])) {

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
				window.location = "tampil.php";
				</script>';
				}
			}
