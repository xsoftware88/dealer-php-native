<?php
session_start();

include "head.php";

if (empty($_SESSION['username']) && ($modul == 'driver')) {
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
    
    $sql    = "SELECT * FROM sales_unit_kirim WHERE id='".$cariID."'";
    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();
?>

<div class="container-fluid">
  <?php 
      if ($dataEdit['approve_driver'] == 1) { ?>
            <div class="control-group">
             <div class="controls">
              Noka : <?php echo strtoupper($dataEdit['noka']); ?>
             </div>
            </div>
            <div class="control-group">
             <div class="controls">
              Type/Warna : <?php echo strtoupper($dataEdit['type_unit']) ." / ". strtoupper($dataEdit['warna_unit']); ?>
             </div>
            </div>
            <div class="control-group">
             <div class="controls">
              Sales : <?php echo strtoupper($dataEdit['sales']); ?>
             </div>
            </div>
            <div class="control-group">
             <div class="controls">
              SPV : <?php echo strtoupper($dataEdit['spv']); ?>
             </div>
            </div>
			<div class="control-group">
             <div class="controls">
              Cabang : <?php echo strtoupper($dataEdit['cabang']); ?>
             </div>
            </div>
			<div class="control-group">
             <div class="controls">
              Nama Customer : <?php echo strtoupper($dataEdit['nama_cust']); ?>
             </div>
            </div>
            <div class="control-group">
             <div class="controls">
              Alamat Customer : <?php echo strtoupper($dataEdit['alamat_cust']); ?>
             </div>
            </div>
			<div class="control-group">
             <div class="controls">
              Kota : <?php echo strtoupper($dataEdit['kota_cust']); ?>
             </div>
            </div>
			<div class="control-group">
             <div class="controls">
              Kecamatan : <?php echo strtoupper($dataEdit['kecamatan_cust']); ?>
             </div>
            </div>
			<div class="control-group">
             <div class="controls">
              No.Telp : <?php echo $dataEdit['nomor_telp']; ?>
             </div>
            </div>
  <?php
      }
  } else {
       //
  }
      ?>
</div>

