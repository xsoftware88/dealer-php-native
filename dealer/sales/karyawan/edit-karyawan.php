<?php

//~ include __DIR__ . "/../../login/head.php";
include __DIR__ . '/../head.php';

    $user  = $_SESSION['username'];
    $modul = $_SESSION['modul'];
    //~ $modul = $_GET['p'];

if (empty($_SESSION['username'])) {
    echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/user/login/form/login.php?p=".$_GET['p']."'
        </script>";
} else {
    $user = $_SESSION['username'];
    $cabang = $_SESSION['cabang'];

    include __DIR__ . '/../menu.php';
}

  if (isset($_GET['id']) && !empty($_GET['id'])) {

    $cariID = $_GET['id'];

    $sql    = "SELECT * FROM master_karyawan WHERE id='".$cariID."'";
    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();
?>
<div class="container">
<form class="form-horizontal" action="prosesedit.php" method="POST">
  <div class="row-fluid">
    <div class="span12">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="ktp">NIK</label>
              <div class="controls">
                <input type="text" id="ktp" name="ktp" value="<?php echo $dataEdit['nik']; ?>">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="nama">Nama</label>
              <div class="controls">
                <input type="text" id="nama" name="nama" value="<?php echo $dataEdit['nama']; ?>">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_ktp">Alamat KTP</label>
              <div class="controls">
                <textarea type="text" id="alamat" name="alamat_ktp"><?php echo $dataEdit['alamat_ktp']; ?></textarea>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_domisili">Alamat Domisili</label>
              <div class="controls">
                <textarea type="text" id="alamat" name="alamat_domisili"><?php echo $dataEdit['alamat_domisili']; ?></textarea>
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="telp">No. Telp</label>
              <div class="controls">
                <input type="text" id="telp" name="telp" value="<?php echo $dataEdit['no_telp']; ?>">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="hp">No. HP</label>
              <div class="controls">
                <input type="text" id="hp" name="hp" value="<?php echo $dataEdit['no_hp']; ?>">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="email">Email</label>
              <div class="controls">
                <input type="text" id="email" name="email" value="<?php echo $dataEdit['email']; ?>">
              </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="rekening">No. Rekening</label>
              <div class="controls">
                <input type="text" id="rekening" name="rekening" value="<?php echo $dataEdit['no_rekening']; ?>">
              </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label class="control-label" for="nama_keluarga">Nama Keluarga</label>
            <div class="controls">
              <input type="text" id="nama" name="nama_keluarga" value="<?php echo $dataEdit['nama_keluarga']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="alamat_keluarga">Alamat Keluarga</label>
            <div class="controls">
              <textarea type="text" id="alamat" name="alamat_keluarga"><?php echo $dataEdit['alamat_keluarga']; ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="no_telp_keluarga">No. Telp</label>
            <div class="controls">
              <input type="text" id="hp" name="no_telp_keluarga" value="<?php echo $dataEdit['no_telp_keluarga']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="no_hp_keluarga">No. HP</label>
            <div class="controls">
              <input type="text" id="hp" name="no_hp_keluarga" value="<?php echo $dataEdit['no_hp_keluarga']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="upload_ktp">Upload KTP</label>
            <div class="controls">
              <input type="text" id="upload_ktp" name="upload_ktp" value="<?php echo $dataEdit['upload_ktp']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="upload_kk">Upload KK</label>
            <div class="controls">
              <input type="text" id="upload_Kk" name="upload_kk" value="<?php echo $dataEdit['upload_kk']; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="jabatan">Jabatan</label>
            <div class="controls">
              <select name="jabatan">
              <option><?php echo $dataEdit['jabatan_sekarang'] ?></option>
                <?php
             $query = "SELECT * FROM master_jabatan WHERE kode_jabatan='10' AND cabang='".$cabang."'";
          $stat = $conn->prepare($query);
          $stat->execute();
          $result = $stat->fetchAll();
            if($stat->rowCount() > 0) {
                  foreach ($result as $jabatan) { ?>
                  <option><?php echo $jabatan['jabatan']; ?></option>
                  <?php }
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="span12">
          <div class="control-group">
              <div class="controls">
              <?php
              if ($dataEdit['active'] == 1) {
            ?>
                <input type="hidden" name="id" value="<?php echo $cariID; ?>">
              <input type="submit" class="btn btn-danger" value="Nonaktif" name="nonaktif">
                  <input type="submit" class="btn btn-primary" value="Update" name="update">
            <?php
              } else {
            ?>
              <input type="submit" class="btn btn-Success" value="Aktif" name="aktif">
          <?php
            }
            ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
<?php
} else {
  //
  echo 'someting error';
}
