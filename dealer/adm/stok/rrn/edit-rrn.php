<?php
session_start();

include "head.php";

if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

  if (isset($_GET['id']) && !empty($_GET['id'])) {

    $cariID = $_GET['id'];
    $sql    = "SELECT * FROM rrn_unit WHERE id='".$cariID."'";

    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();

?>
<div class="container">
<form class="form-horizontal" action="update-rrn.php" method="POST">
<div class="row=fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="rrn">No. RRN</label>
    <div class="controls">
      <input type="text" class="input-large" id="rrn" name="rrn" value="<?php echo $dataEdit['no_rrn'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="mdp">Alokasi MDP</label>
    <div class="controls">
      <input type="text" class="tgl" id="mdp" name="mdp" value="<?php echo $dataEdit['alokasi_mdp'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="supplier">Supplier</label>
    <div class="controls">
      <input type="text" class="input-large" id="supplier" name="supplier" value="<?php echo $dataEdit['supplier'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Noka</label>
    <div class="controls">
    	<input type="text" class="tgl" id="noka" name="noka" value="<?php echo $dataEdit['noka'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nosin">Nosin</label>
    <div class="controls">
      <input type="text" class="input-large" id="nosin" name="nosin" value="<?php echo $dataEdit['nosin'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Tipe</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe" value="<?php echo $dataEdit['tipe_name'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
      <input type="text" class="input-large" id="model" name="model" value="<?php echo $dataEdit['model_code'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="suffix">Suffix</label>
    <div class="controls">
      <input type="text" class="input-large" id="suffix" name="suffix" value="<?php echo $dataEdit['suffix'];?>">
    </div>
  </div>
</div>
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="kodewarna">Kode Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="kodewarna" name="kodewarna" value="<?php echo $dataEdit['kode_warna'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna Kendaraan</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna" value="<?php echo $dataEdit['warna_kendaraan'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="posisi">Posisi Kendaraan</label>
    <div class="controls">
      <input type="text" class="input-large" id="posisi" name="posisi" value="<?php echo $dataEdit['posisi_unit'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="keterangan">Keterangan</label>
    <div class="controls">
      <textarea name="keterangan"><?php echo $dataEdit['keterangan'];?></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kodeproduksi">Kode Produksi</label>
    <div class="controls">
      <input type="text" class="input-large" id="kodeproduksi" name="kodeproduksi" value="<?php echo $dataEdit['kode_produksi'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="status">Status</label>
    <div class="controls">
      <input type="text" class="input-large" id="status" name="status" value="<?php echo $dataEdit['status_unit'];?>">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
      <input type="submit" class="btn btn-primary" value="Update" name="update">
      <input type="submit" class="btn btn-danger" value="Hapus" name="hapus">
    </div>
  </div>
</div>
</div>
</div>
</div>
</form>
</div>
<?php } else {
// buang ke depan, g isa edit g ada id
  } ?>