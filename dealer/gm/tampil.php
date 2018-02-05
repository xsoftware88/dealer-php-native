<?php
session_start();

include "head.php";

if (!empty($_SESSION['username']))
	{
		$user = $_SESSION['username'];
		$cabang = $_SESSION['cabang'];

	} else {
		echo "<script type='text/javascript'>
                    window.location = '../user/login/form/login.php';
                </script>";
	}

	$statement = "SELECT * FROM master_karyawan 
			WHERE tempat_sekarang='".$cabang."'
			AND jabatan_sekarang='SSE' 
			OR jabatan_sekarang='SE' 
			OR jabatan_sekarang='JSE' 
			OR jabatan_sekarang='trainee'";
	$stmt = $conn->prepare($statement);
	$stmt->execute();
	$result = $stmt->fetchAll();

?>
<style>
	.table {
		font-size: 13px;
	}
	.
</style>
<div class="container-fluid">
	<form id="formCari" class="form-inline" action="" method="POST" name="cari">
    <!-- Select Basic -->
	    <div class="control-group">
		    <label class="control-label" for="nama">Nama :</label>
		    <select name="nama" id="nama">
		    	<option></option>
				<?php foreach ($result as $nama) { ?>
		    		<option value="<?php echo $nama['nama']; ?>"><?php echo strtoupper($nama['nama']); ?></option>
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
        	<label class="control-label" for="nama">Tahun :</label>
		    <select name="tahun" id="tahun">
		    </select>
		    <input type="submit" class="btn btn-primary" name ="cari" value="Cari" id="cari">
	  	</div>
	</form>

	<?php
if (isset($_POST['cari'])) {

	$bulan = $_POST['bulan'];
	$sales = $_POST['nama'];
	$tahun = $_POST['tahun'];

	$statement = "SELECT * FROM sales_unit_kirim 
		WHERE sales='".$sales."' 
		AND hapus=0
		AND month(tgl_simpan)='".$bulan."' 
		AND year(tgl_simpan)='".$tahun."'";

	$stmt = $conn->prepare($statement);
	$stmt->execute();
	$result = $stmt->fetchAll(); ?>

	<div class="well">
		Nama Sales : <?php echo $sales; ?>
		<br>
		<br>
		Poin Bulan ini : 
		<?php 
		$poin = count($result);
		echo $poin;
		?>
	</div>
	<table class="table table-bordered table-responsive">
		<thead>
			<tr>
				<th>SPV</th>
				<th>SPK</th>
				<th>Type / Warna</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($result as $data) { ?>
			<tr>
				<td><?php echo $data['spv']; ?></td>
				<td><?php echo $data['nomor_spk']; ?></td>
				<td><?php echo $data['type_unit'] ."/". $data['warna_unit']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>
<script type="text/javascript">
var start = 2017;
var end = new Date().getFullYear();
var options = "";
for(var year = start ; year <=end; year++){
  options += "<option value="+ year +">"+ year +"</option>";
}
document.getElementById("tahun").innerHTML = options;
</script>