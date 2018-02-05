<?php
//session_start();

//~ include __DIR__ . "/../../login/head.php";
include __DIR__ . '/../../head.php';

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

    include __DIR__ . '/../../menu.php';
}

  $statement = "SELECT DISTINCT nama FROM master_karyawan WHERE user_input='".$user."' AND active=1";
  $stmt = $conn->prepare($statement);
  $stmt->execute();
  $result = $stmt->fetchAll();
?>

<div class="container">
<form class="form-horizontal" action="simpan.php" method="POST">
<div class="row=fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="spk">Nomor SPK</label>
    <div class="controls">
      <input type="text" class="input-large" id="spk" name="spk">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tgl_spk">Tanggal SPK</label>
    <div class="controls">
      <input type="text" class="tgl" id="tgl_spk" name="tgl_spk">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="jenis">Jenis Penjualan</label>
    <div class="controls">
      <select name="jenis" class="jenis">
          <option>Tunai</option>
          <option>Kredit</option>
      </select>
    </div>
  </div>
  <div class="control-group leasing">
    <label class="control-label" for="leasing">Leasing</label>
    <div class="controls">
      <input type="text" class="input-large" id="leasing" name="leasing">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="sales">Sales</label>
    <div class="controls">
      <select name="sales">
        <?php if($stmt->rowCount() > 0) {
          foreach ($result as $sales) { ?>
          <option><?php echo strtoupper($sales['nama']); ?></option>
          <?php }
          } ?>
      </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nama">Nama Customer</label>
    <div class="controls">
      <input type="text" class="input-large" id="nama" name="nama_cust">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="alamat">Alamat</label>
    <div class="controls">
      <textarea type="text" id="alamat" name="alamat"></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kota">Kota</label>
    <div class="controls">
      <select name="kota">
       <option>Bangkalan</option>
       <option>Banyuwangi</option>
       <option>Kab.Blitar</option>
       <option>Bojonegoro</option>
       <option>Bondowoso</option>
       <option>Gresik</option>
       <option>Jember</option>
       <option>Jombang</option>
       <option>Kab.Kediri</option>
       <option>Lamongan</option>
       <option>Lumajang</option>
       <option>Kab.Madiun</option>
       <option>Magetan</option>
       <option>Kab.Malang</option>
       <option>Kab.Mojokerto</option>
       <option>Nganjuk</option>
       <option>Ngawi</option>
       <option>Pacitan</option>
       <option>Pamekasan</option>
       <option>Kab.Pasuruan</option>
       <option>Ponorogo</option>
       <option>Kab.Probolinggo</option>
       <option>Sampang</option>
       <option>Sidoarjo</option>
       <option>Situbondo</option>
       <option>Sumenep</option>
       <option>Trenggalek</option>
       <option>Tuban</option>
       <option>Tulungagung</option>
       <option>Batu</option>
       <option>Blitar</option>
       <option>Kediri</option>
       <option>Madiun</option>
       <option>Malang</option>
       <option>Mojokerto</option>
       <option>Pasuruan</option>
       <option>Probolinggo</option>
       <option>Surabaya</option>
    </select>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kota">Kecamatan / Desa</label>
    <div class="controls">
      <input type="text" class="input-large" id="kecamatan" name="kecamatan">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kota">Gesekan</label>
    <div class="controls">
      <input type="text" class="input-large" id="gesekan" name="gesekan">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="Opsi">Opsi Pengiriman</label>
    <label class="radio">
      <div class="controls">
        <input type="radio" name="optionsRadios" id="option[]" value="Driver" checked>Driver
      </div>
    </label>
    <label class="radio">
      <div class="controls">
        <input type="radio" name="optionsRadios" id="option[]" value="Sales">Kirim Sendiri
      </div>
    </label>
    <label class="radio">
      <div class="controls">
        <input type="radio" name="optionsRadios" id="option[]" value="Cabang">Cabang
      </div>
    </label>
  </div>
</div>
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="npwp">NPWP Customer</label>
    <div class="controls">
      <input type="text" class="input-large" id="npwp" name="npwp">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="telp">No. Telp</label>
    <div class="controls">
      <input type="text" class="input-large" id="telp" name="telp">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="email">Email Customer</label>
    <div class="controls">
      <input type="text" class="input-large" id="email" name="email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Nomor BAST</label>
    <div class="controls">
      <input type="text" class="input-large" id="bast" name="bast">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tgl_bast">Tanggal BAST</label>
    <div class="controls">
      <input type="text" class="tgl" id="tgl_bast" name="tgl_bast">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Noka</label>
    <div class="controls">
      <input type="text" class="input-large" id="noka" name="noka">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nosin">Nosin</label>
    <div class="controls">
      <input type="text" class="input-large" id="nosin" name="nosin">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tipe">Tipe Unit</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tahun">Tahun</label>
    <div class="controls">
      <input type="text" class="input-large" id="tahun" name="tahun">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nopol">Nopol</label>
    <div class="controls">
      <input type="text" class="input-large" id="nopol" name="nopol">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="variasi">Variasi</label>
    <div class="controls">
      <textarea type="text" id="variasi" name="variasi"></textarea>
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
<script type="text/javascript">
    $(function(){
        $(".tgl").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly": true,
          "autodateOnStart": false
        });
    });
  $(function() {
      $(".leasing").hide();
      $(".jenis").change(function() {
          if($(".jenis").val() == "Kredit") {
              $(".leasing").show();
            } else {
              $(".leasing").hide();
            }
        });
    });
</script>
