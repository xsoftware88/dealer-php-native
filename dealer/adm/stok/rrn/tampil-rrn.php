<?php
session_start();

	include "head.php";

	$user = $_SESSION['username'];
	$cabang = $_SESSION['cabang'];
	
	if (!empty($user) && ($modul == 'stok')) {
		
		$statement = "SELECT * 
				FROM rrn_unit";

		$stmt = $conn->prepare($statement);
		$stmt->execute();
    	$dataRow = $stmt->rowCount();
	} else {
		echo "<script type='text/javascript'>
                    window.location = '../../login/login-form.php';
                </script>";
	}
?>

<style>
	.table {
		font-size: 12px;
		table-layout: fixed;
		word-wrap: break-word;
	}
</style>
<div class="container-fluid">
	<form id="formCari" class="form-inline" action="" method="POST">
    <!-- Select Basic -->
    <div class="control-group">
	    <label class="control-label" for="tanggal">Mulai dari :</label>
	    <input type="text" class="dtpick" id="tanggal" name="mulai">
	    <label class="control-label" for="tanggal">Sampai :</label>
	    <input type="text" class="dtpick" id="tanggal" name="sampai">
	    <input type="submit" class="btn btn-primary" name ="cariData" value="Cari">
  	</div>
</form>

<?php 
if (!$_POST) {
	// tanpa search
?>
	<table class="table table-bordered table-responsive">
		<thead>
		<tr>
			<th class="rrn">No. RRN</th>
			<th class="mdp">Alokasi</th>
        	<th class="supplier">Supplier</th>
			<th class="noka">Noka</th>
			<th class="nosin">Nosin</th>
        	<th class="tipe">Tipe</th>
        	<th class="model">Model</th>
        	<th class="suffix">Suffix</th>
        	<th class="kodewarna">Kode Warna</th>
			<th class="warna">Warna</th>
        	<th class="posisi">Posisi</th>
        	<th class="keterangan">Keterangan</th>
        	<th class="kodeproduksi">Kode Produkksi</th>
        	<th class="status">Status</th>
		</tr>
		</thead>
		
		<?php 
		if ($dataRow > 0) {
			$data = $stmt->fetchAll();
		?>
		
		<tbody>
        	<?php foreach ($data as $val) { ?>
		<tr>
			<td><?php echo $val['no_rrn']; ?></td>
			<td><?php echo $val['alokasi_mdp']; ?></td>
        	<td><?php echo $val['supplier']; ?></td>
			<td><a href="edit-rrn.php?id=<?php echo $val['id'];?>"><?php echo $val['noka']; ?></a></td>
			<td><?php echo $val['nosin']; ?></td>
        	<td><?php echo $val['tipe_name']; ?></td>
        	<td><?php echo $val['model_code']; ?></td>
        	<td><?php echo $val['suffix']; ?></td>
        	<td><?php echo $val['kode_warna']; ?></td>
			<td><?php echo $val['warna_kendaraan']; ?></td>
        	<td><?php echo $val['posisi_unit']; ?></td>
        	<td><?php echo $val['keterangan']; ?></td>
        	<td><?php echo $val['kode_produksi']; ?></td>
        	<td><?php echo $val['status_unit']; ?></td>
		</tr>
        <?php } ?>
		</tbody>
<?php
	}
?>
	</table>
	

	<?php } elseif (isset($_POST)) {
		/*if (!empty($_POST['mulai']) && !empty($_POST['sampai'])) {
// untuk search
		
		$mulai = $_POST['mulai'] . ' 00:00:00';
		$sampai = $_POST['sampai'] . ' 23:59:59';

		if (!empty($_SESSION['username'])) {
				$searchStmt = "SELECT * 
				FROM sales_unit_kirim 
				WHERE  spv = '".$user."' 
				AND jam_kirim < '".$sampai."' 
				AND jam_kirim > '".$mulai."' 
				ORDER BY jam_kirim ASC";
		} else {
			$searchStmt = "SELECT * 
				FROM sales_unit_kirim 
				WHERE jam_kirim < '".$sampai."' 
				AND jam_kirim > '".$mulai."' 
				ORDER BY jam_kirim ASC";
		}

		$search = $conn->prepare($searchStmt);
		$search->execute(); */
		?> 

		<table class="table table-bordered table-responsive">
		<thead>
		<tr>
			<th class="rrn">No. RRN</th>
			<th class="mdp">Alokasi</th>
        	<th class="supplier">Supplier</th>
			<th class="noka">Noka</th>
			<th class="nosin">Nosin</th>
        	<th class="tipe">Tipe</th>
        	<th class="model">Model</th>
        	<th class="suffix">Suffix</th>
        	<th class="kodewarna">Kode Warna</th>
			<th class="warna">Warna</th>
        	<th class="posisi">Posisi</th>
        	<th class="keterangan">Keterangan</th>
        	<th class="kodeproduksi">Kode Produkksi</th>
        	<th class="status">Status</th>
		</tr>
		</thead>
		
		<?php 
		if ($dataRow > 0) {
			$data = $stmt->fetchAll();
		?>
		
		<tbody>
        	<?php foreach ($data as $val) { ?>
		<tr>
			<td><?php echo $val['no_rrn']; ?></td>
			<td><?php echo $val['alokasi_mdp']; ?></td>
        	<td><?php echo $val['supplier']; ?></td>
			<td><a href="edit-rrn.php?id=<?php echo $val['id'];?>"><?php echo $val['noka']; ?></a></td>
			<td><?php echo $val['nosin']; ?></td>
        	<td><?php echo $val['tipe_name']; ?></td>
        	<td><?php echo $val['model_code']; ?></td>
        	<td><?php echo $val['suffix']; ?></td>
        	<td><?php echo $val['kode_warna']; ?></td>
			<td><?php echo $val['warna_kendaraan']; ?></td>
        	<td><?php echo $val['posisi_unit']; ?></td>
        	<td><?php echo $val['keterangan']; ?></td>
        	<td><?php echo $val['kode_produksi']; ?></td>
        	<td><?php echo $val['status_unit']; ?></td>
		</tr>
        	<?php } ?>
		</tbody>
<?php
		}
	}
?>
	</table>
</div>
<script type="text/javascript">
    $(function(){
        $(".dtpicker").appendDtpicker({
            "closeOnSelected": true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
    $(function(){
        $(".dtpick").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly" : true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
</script>
