<?php
include '../../conf/conf.php';
?>
<div class="container-fluid">
	<form id="formCari" class="form-inline" action="" method="POST">
    <!-- Select Basic -->
	    <div class="control-group">
		    <label class="control-label" for="nama">Nama :</label>
		    <select name="nama">
		    	<?php 
		    	$statement = "SELECT nama FROM master_karyawan";
				$stmt = $conn->prepare($statement);
				$stmt->execute();
				$result = $stmt->fetchAll();

		    	foreach ($result as $nama) { ?>
		    		<option value="<?php echo $nama['nama']; ?>"><?php echo $nama['nama']; ?></option>
		    	<?php } ?>
		    </select>
		    <label class="control-label" for="tanggal">Bulan :</label>
		    <select name="bulan">
		    	<option value="01">Januari</option>
		    	<option value="02">Februari</option>
		    	<option value="03">Maret</option>
		    	<option value="04">April</option>
		    	<option value="05">Mei</option>
		    	<option value="06">Juni</option>
		    	<option value="07">Juli</option>
		    	<option value="08">Agustus</option>
		    	<option value="09">September</option>
		    	<option value="10">Oktober</option>
		    	<option value="11">November</option>
		    	<option value="12">Desember</option>
		    </select>
		    <input type="submit" class="btn btn-primary" name ="cariData" value="Cari">
	  	</div>
	</form>
</div>
<?php
if ($_POST) {

	$bulan = $_POST['bulan'];
	$nama = $_POST['nama'];

	$statement = "SELECT * FROM sales_unit_kirim WHERE sales='".$nama."' AND month(tgl_simpan)='".$bulan."'";
	$stmt = $conn->prepare($statement);
	$stmt->execute();
	$result = $stmt->fetchAll();

	echo "<pre>";
	var_dump($result);
	exit;
}