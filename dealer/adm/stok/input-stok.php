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
    $cabang = $_SESSION['cabang'];
}
?>
<div class="container">
<form class="form-horizontal" action="simpan-stok.php" method="POST">
<div class="row=fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="rrn">No. RRN</label>
    <div class="controls">
      <input type="text" class="input-large" id="rrn" name="rrn">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="cabang">Cabang</label>
    <div class="controls">
      <input type="text" class="tgl" id="cabang" name="cabang">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Noka</label>
    <div class="controls">
    	<input type="text" class="tgl" id="noka" name="noka">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nosin">Nosin</label>
    <div class="controls">
      <input type="text" class="input-large" id="nosin" name="nosin">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="supplier">Supplier</label>
    <div class="controls">
      <input type="text" class="input-large" id="supplier" name="supplier">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
      <input type="text" class="input-large" id="model" name="model">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Tipe</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input type="submit" class="btn btn-primary" value="Simpan" name="simpan">
    </div>
  </div>
</div>
</div>
</div>
</div>
</form>
</div>
