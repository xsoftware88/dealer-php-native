<?php 
session_start();

include __DIR__ . "/head.php";

if (!empty($_SESSION['username']) && $modul == 'hrd') {
    $user = $_SESSION['username'];
} else {
  echo "<script type='text/javascript'>
        window.location = '../login/login-form.php';
    </script>";
}
  
  $statement = "SELECT DISTINCT divisi,jabatan FROM master_jabatan";
  $stmt = $conn->prepare($statement);
  $stmt->execute();
  $result = $stmt->fetchAll();

?>
<style>
  .table{
    font-size: 13px;
  }
</style>
<div class="container">
<form class="form-horizontal" action="prosesdaftar.php" method="POST">
  <div class="row-fluid">
    <div class="span12">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="ktp">NIK</label>
              <div class="controls">
                <input type="text" id="ktp" name="ktp">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="nama">Nama</label>
              <div class="controls">
                <input type="text" id="nama" name="nama">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_ktp">Alamat KTP</label>
              <div class="controls">
                <textarea type="text" id="alamat" name="alamat_ktp"></textarea>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_domisili">Alamat Domisili</label>
              <div class="controls">
                <textarea type="text" id="alamat" name="alamat_domisili"></textarea>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="telp">No. Telp</label>
              <div class="controls">
                <input type="text" id="telp" name="telp">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="hp">No. HP</label>
              <div class="controls">
                <input type="text" id="hp" name="hp">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email">Email</label>
              <div class="controls">
                <input type="text" id="email" name="email">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="rekening">No. Rekening</label>
              <div class="controls">
                <input type="text" id="rekening" name="rekening">
              </div>
          </div>
        <div class="control-group">
            <div class="controls">
              <input type="submit" class="btn btn-primary" value="Daftar" name="daftar">
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="nama_keluarga">Nama Keluarga</label>
            <div class="controls">
              <input type="text" id="nama" name="nama_keluarga">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_keluarga">Alamat Keluarga</label>
            <div class="controls">
              <textarea type="text" id="alamat" name="alamat_keluarga"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="no_telp_keluarga">No. Telp</label>
            <div class="controls">
              <input type="text" id="hp" name="no_telp_keluarga">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="no_hp_keluarga">No. HP</label>
            <div class="controls">
              <input type="text" id="hp" name="no_hp_keluarga">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="upload_ktp">Upload KTP</label>
            <div class="controls">
              <input type="text" id="upload_ktp" name="upload_ktp">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="upload_kk">Upload KK</label>
            <div class="controls">
              <input type="text" id="upload_Kk" name="upload_kk">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="tgl_masuk">Tanggal Masuk</label>
            <div class="controls">
              <input type="text" id="tgl_masuk" name="tgl_masuk">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="tgl_keluar">Tanggal Keluar</label>
            <div class="controls">
              <input type="text" id="tgl_keluar" name="tgl_keluar">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="jabatan">Jabatan</label>
            <div class="controls">
              <select name="jabatan">
                <?php if($stmt->rowCount() > 0) { 
                  foreach ($result as $jabatan) { ?>
                  <option><?php echo $jabatan['divisi']."-".$jabatan['jabatan']; ?></option>
                  <?php }
                  } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="cabang">Cabang</label>
            <div class="controls">
              <select name="cabang">
                <?php
                $query = "SELECT cabang FROM master_jabatan GROUP BY cabang";
                $sql = $conn->prepare($query);
                $sql->execute();
                $data = $sql->fetchAll();
                  
                  foreach ($data as $cabang) { ?>
                  <option><?php echo $cabang['cabang']; ?></option>
                  <?php 
                  } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>

<script type="text/javascript">
    $(function(){
        $("#tgl_masuk").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly" : true,
        });
    $("#tgl_keluar").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly" : true,
            "autodateOnStart": false,
        });
    });
</script>
