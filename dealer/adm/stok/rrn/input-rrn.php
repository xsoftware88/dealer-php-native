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
    $cabang = $_SESSION['cabang'];
}
?>
<div class="container">
<form class="form-horizontal" action="simpan-rrn.php" method="POST">
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
    <label class="control-label" for="mdp">Alokasi MDP</label>
    <div class="controls">
      <input type="text" class="tgl" id="mdp" name="mdp">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="supplier">Supplier</label>
    <div class="controls">
      <input type="text" class="input-large" id="supplier" name="supplier">
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
    <label class="control-label" for="warna">Tipe</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="model">Model</label>
    <div class="controls">
      <input type="text" class="input-large" id="model" name="model">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="suffix">Suffix</label>
    <div class="controls">
      <input type="text" class="input-large" id="suffix" name="suffix">
    </div>
  </div>
</div>
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="kodewarna">Kode Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="kodewarna" name="kodewarna">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna Kendaraan</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="posisi">Posisi Kendaraan</label>
    <div class="controls">
      <input type="text" class="input-large" id="posisi" name="posisi">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="keterangan">Keterangan</label>
    <div class="controls">
      <textarea name="keterangan"></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kodeproduksi">Kode Produksi</label>
    <div class="controls">
      <input type="text" class="input-large" id="kodeproduksi" name="kodeproduksi">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="status">Status</label>
    <div class="controls">
      <input type="text" class="input-large" id="status" name="status">
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
