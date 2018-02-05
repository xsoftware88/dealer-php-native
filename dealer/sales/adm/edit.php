<?php
session_start();

include __DIR__ . '/../../login/head.php';

if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
    $modul = $_SESSION['modul'];
}

  if (isset($_GET['id']) && !empty($_GET['id'])) {

    $cariID = $_GET['id'];
    
    if (isset($_SESSION['username']) && $_SESSION['username'] == ($modul == 'admin')) {
      $sql    = "SELECT * FROM sales_unit_kirim WHERE id='".$cariID."'";
      $stmt   = $conn->prepare($sql);
    } 

    $stmt->execute();
    $dataEdit = $stmt->fetch();
?>
<div class="container">
<form class="form-horizontal" action="update.php" method="POST">
<div class="row=fluid">
<div class="span12">
<div class="row-fluid">
<div class="span6">
  <div class="control-group">
    <label class="control-label" for="tanggal">Tanggal / Jam Kirim</label>
    <div class="controls">
      <input type="text" class="dtpicker" id="tanggal" name="jam">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="spk">Nomor SPK</label>
    <div class="controls">
      <input type="text" class="input-large" id="spk" name="spk" value="<?php echo $dataEdit['nomor_spk']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tgl_spk">Tanggal SPK</label>
    <div class="controls">
      <input type="text" class="tgl" id="tgl_spk" name="tgl_spk" value="<?php echo $dataEdit['tgl_spk']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="jenis">Jenis Penjualan</label>
    <div class="controls">
      <select name="jenis" class="jenis">
      		<option><?php echo $dataEdit['jenis_penjualan']; ?></option>
        	<option>Tunai</option>
        	<option>Kredit</option>
    	</select>
    </div>
  </div>
  <div class="control-group leasing">
    <label class="control-label" for="leasing">Leasing</label>
    <div class="controls">
      <input type="text" class="input-large" id="leasing" name="leasing" value="<?php echo $dataEdit['leasing']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="sales">Sales</label>
    <div class="controls">
      <input class="input-large" type="text" name="sales" placeholder="<?php echo strtoupper($dataEdit['sales']); ?>" disabled>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nama">Nama Customer</label>
    <div class="controls">
      <input type="text" class="input-large" id="nama" name="nama_cust" value="<?php echo $dataEdit['nama_cust']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="alamat">Alamat</label>
    <div class="controls">
      <textarea type="text" id="alamat" name="alamat"><?php echo $dataEdit['alamat_cust']; ?></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kota">Kota</label>
    <div class="controls">
      <select name="kota">
      <option><?php echo $dataEdit['kota_cust']; ?></option>
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
      <input type="text" class="input-large" id="kecamatan" name="kecamatan" value="<?php echo $dataEdit['kecamatan_cust']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="kota">Gesekan</label>
    <div class="controls">
      <input type="text" class="input-large" id="gesekan" name="gesekan" value="<?php echo $dataEdit['gesekan']; ?>">
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
      <input type="text" class="input-large" id="npwp" name="npwp" value="<?php echo $dataEdit['npwp_cust']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="telp">No. Telp</label>
    <div class="controls">
      <input type="text" class="input-large" id="telp" name="telp" value="<?php echo $dataEdit['nomor_telp']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="email">Email Customer</label>
    <div class="controls">
      <input type="text" class="input-large" id="email" name="email" value="<?php echo $dataEdit['email_cust'];?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Nomor BAST</label>
    <div class="controls">
      <input type="text" class="input-large" id="bast" name="bast" value="<?php echo $dataEdit['nomor_bast']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tgl_bast">Tanggal BAST</label>
    <div class="controls">
      <input type="text" class="tgl" id="tgl_bast" name="tgl_bast" value="<?php echo $dataEdit['tgl_bast']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="noka">Noka</label>
    <div class="controls">
      <input type="text" class="input-large" id="noka" name="noka" value="<?php echo $dataEdit['noka']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nosin">Nosin</label>
    <div class="controls">
      <input type="text" class="input-large" id="nosin" name="nosin" value="<?php echo $dataEdit['nosin']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tipe">Tipe Unit</label>
    <div class="controls">
      <input type="text" class="input-large" id="tipe" name="tipe" value="<?php echo $dataEdit['type_unit']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="warna">Warna</label>
    <div class="controls">
      <input type="text" class="input-large" id="warna" name="warna" value="<?php echo $dataEdit['warna_unit']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="tahun">Tahun</label>
    <div class="controls">
      <input type="text" class="input-large" id="tahun" name="tahun" value="<?php echo $dataEdit['tahun_unit']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="nopol">Nopol</label>
    <div class="controls">
      <input type="text" class="input-large" id="nopol" name="nopol" value="<?php echo $dataEdit['nopol_unit']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="variasi">Variasi</label>
    <div class="controls">
      <textarea type="text" id="variasi" name="variasi"><?php echo $dataEdit['variasi']; ?></textarea>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
      <?php 
        if (isset($_SESSION['username']) && $modul == 'admin') { ?>
          <input type="submit" class="btn btn-primary" value="Update" name="update">
          <?php
          if ($dataEdit['approve_adm'] == 1) {
      ?>
      <input type="submit" class="btn btn-danger" value="Batal" name="batal">
      <?php 
    } else {
      ?>
      <input type="submit" class="btn btn-Success" value="Setuju" name="setuju">
    <?php
    }
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
<script type="text/javascript">
    $(function(){
        $(".dtpicker").appendDtpicker({
            "closeOnSelected": true,
            "futureOnly": true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    	$(".tgl").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly": true,
        	"autodateOnStart": false
        });
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
<?php } else {
// buang ke depan, g isa edit g ada id
  } ?>