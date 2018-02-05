<?php
session_start();

include "head.php";

	if (!empty($_SESSION['username']) && $modul='kepala_cabang') {
		$user = $_SESSION['username'];
		$cabang = $_SESSION['cabang'];
	} else {
		echo "<script type='text/javascript'>
                    window.location = '../../login/login-form.php';
                </script>";
	}

	$statement = "SELECT * FROM master_karyawan 
			WHERE tempat_sekarang='".$cabang."'
			AND jabatan_sekarang='SPV'";
	$stmt = $conn->prepare($statement);
	$stmt->execute();
	$result = $stmt->fetchAll();

	//$statement = "SELECT * FROM master_karyawan 
	//		WHERE tempat_sekarang='".$cabang."'
	//		AND jabatan_sekarang='SSE' 
	//		OR jabatan_sekarang='SE' 
	//		OR jabatan_sekarang='JSE' 
	//		OR jabatan_sekarang='trainee'";
	//$stmt = $conn->prepare($statement);
	//$stmt->execute();
	//$result = $stmt->fetchAll();

	//echo "<pre>";
	//var_dump($nama);
	//exit;
?>

<div class="container-fluid">
	<form id="formCari" class="form-inline" action="" method="POST" name="cari">
    <!-- Select Basic -->
	    <div class="control-group">
		    <label class="control-label" for="bulan">Bulan :</label>
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

	if (isset($_POST['cari'])) 
    {
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$query = "SELECT * FROM point_sales 
        		WHERE month(tgl_simpan)='".$bulan."'
        		AND year(tgl_simpan)='".$tahun."'";
    	$run = $conn->prepare($query);
    	$run->execute();
    	$poin = $run->fetchAll();
?>
<style>
	.table {
		font-size:13px;
    	font-family:"Verdana";
	}
</style>
	<div class="row-fluid">
					<?php foreach($result as $data) { ?>
		<div class="span3">
			<div class="well">
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th><?php echo strtoupper($data['nama']); ?></th>
							<th>Poin</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = "SELECT DISTINCT nama_karyawan FROM hirarki_karyawan WHERE nama_atasan='".$data['nama']."'";
						$sales = $conn->prepare($query);
						$sales->execute();
						$nama = $sales->fetchAll();

						//echo "<pre>";
						//var_dump($nama);
						//exit;

						foreach ($nama as $sales) { 
                        	$namaKaryawan = strtoupper($sales['nama_karyawan']);
							echo "<tr>";
							echo "<td>$namaKaryawan</td>";

							$sql = "SELECT nama FROM point_sales 
									WHERE nama='".$sales['nama_karyawan']."'
									AND month(tgl_simpan)='".$bulan."'
									AND year(tgl_simpan)='".$tahun."'";
							$poin = $conn->prepare($sql);
							$poin->execute();
							$point = count($poin->fetchAll());

							echo "<td>$point</td></tr>";
						}
						 ?>
					</tbody>
                	<tfoot>
                        <?php 
							$cariTotal = "SELECT * FROM point_sales WHERE spv='".$data['nama']."'";
                            $siap = $conn->prepare($cariTotal);
							$siap->execute();
							$total = count($siap->fetchAll());
                        ?>
                    	<tr>
                        <td><strong>Total Poin</strong></td>
                        <td><strong><?php echo $total; ?></strong></td>
                    	</tr>
                	</tfoot>
				</table>
			</div>
		</div>
		<?php } ?>	
	</div>
<?php } ?>
</div>
<script type="text/javascript">
var start = 2015;
var end = new Date().getFullYear();
var options = "";
for(var year = start ; year <=end; year++){
  options += "<option value="+ year +">"+ year +"</option>";
}
document.getElementById("tahun").innerHTML = options;
</script>