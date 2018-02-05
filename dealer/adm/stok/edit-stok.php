<?php
session_start();

include "head.php";

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
    $sql    = "SELECT * FROM stok_unit WHERE id='".$cariID."'";

    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();

?>
<div class="container">
<form class="form-horizontal" action="update-stok.php" method="POST">
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
    <label class="control-label" for="cabang">Cabang</label>
    <div class="controls">
      <input type="text" class="tgl" id="cabang" name="cabang" value="<?php echo $dataEdit['cabang'];?>">
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
    <label class="control-label" for="supplier">Supplier</label>
    <div class="controls">
      <input type="text" class="input-large" id="supplier" name="supplier" value="<?php echo $dataEdit['supplier'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna" value="<?php echo $dataEdit['warna_unit'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
      <input type="text" class="input-large" id="model" name="model" value="<?php echo $dataEdit['model_unit'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Tipe</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe" value="<?php echo $dataEdit['tipe_unit'];?>">
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