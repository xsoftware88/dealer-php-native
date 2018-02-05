<?php
//session_start();

include __DIR__ . "/../head.php";
include __DIR__ . "/../menu.php";
?>

<style>
	.table {
		font-size: 10px;
		word-wrap: break-word;
		}
</style>
<div class="container-fluid">
	<form id="formCari" class="form-inline" action="" method="POST">
    	<!-- Select Basic -->
    	<div class="control-group">
	    	<label class="control-label" for="modelUnit">Model Unit :</label>
	    	<input type="text" id="modelUnit" name="modelUnit">
	    	<label class="control-label" for="tipeUnit">Tipe Unit :</label>
	    	<input type="text" id="tipeUnit" name="tipeUnit">
	    	<label class="control-label" for="warnaUnit">Warna Unit :</label>
	    	<input type="text" id="warnaUnit" name="warnaUnit">
	    	<input type="submit" class="btn btn-primary" id="cari" name ="cariData" value="Cari">
  		</div>
	</form>
<?php
	function tampil($dataRow, $stmt) 
    { 
?>
	<table class="table table-responsive">
		<thead>
		<tr>
			<th class="rrn">RRN</th>
        	<th class="suffix">Suffix</th>
        	<th class="katashikisuffix">Katashiki Suffix</th>
        	<th class="model">Model</th>
        	<th class="namaunit">Nama Unit</th>
        	<th class="kodemodel">Kode Model</th>
        	<th class="kodenama">Kode Nama</th>
			<th class="kodewarna">Kode Warna</th>
        	<th class="warna">Warna</th>
        	<th class="noka">Noka</th>
        	<th class="nosin">Nosin</th>
        	<th class="nosinprefix">Nosin Prefix</th>
			<th class="productiondate">Production Date</th>
        	<th class="pdidate">PDI Date</th>
        	<th class="dealer">Dealer</th>
        	<th class="area">Area</th>
			<th class="branch">Branch</th>
        	<th class="destination">Destination</th>
        	<th class="assignflag">Assign Flag</th>
			<th class="enddestination">End Destination</th>
        	<th class="supplier">Supplier</th>
        	<th class="status">Status</th>
        	<th class="tamdonumber">TAM DO Number</th>
        	<th class="faktur">Faktur</th>
        	<th class="tanggalfaktur">Tanggal Faktur</th>
        	<th class="tanggaldo">Tanggal DO</th>
        	<th class="tanggalmasuk">Tanggal Masuk</th>
        	<th class="antarcabang">Penjualan Antar Cabang</th>
        	<th class="vincode">VIN Code</th>
        	<th class="alokasiunit">Alokasi Unit</th>
        	<th class="nomorspk">Nomor SPK</th>
        	<th class="nomorbast">Nomor BAST</th>
        	<th class="statusbast">Status BAST</th>
        	<th class="statusafi">Status AFI</th>
		</tr>
		</thead>
		
		<?php 
		if ($dataRow > 0) {
			$data = $stmt->fetchAll();
		?>
		
		<tbody>
        	<?php foreach ($data as $val) { ?>
		<tr>
			<td><?php echo $val['rrn']; ?></td>
        	<td><?php echo $val['suffix']; ?></td>
			<td><?php echo $val['katashiki']; ?></td>
        	<td><?php echo $val['katashiki_suffix']; ?></td>
			<td><?php echo $val['model']; ?></td>
			<td><?php echo $val['nama_unit']; ?></td>
			<td><?php echo $val['kode_model']; ?></td>
        	<td><?php echo $val['kode_warna']; ?></td>
        	<td><?php echo $val['warna']; ?></td>
			<td><?php echo $val['noka']; ?></td>
        	<td><?php echo $val['nosin']; ?></td>
        	<td><?php echo $val['nosin_prefix']; ?></td>
			<td><?php echo $val['produksi_date']; ?></td>
        	<td><?php echo $val['pdi_date']; ?></td>
        	<td><?php echo $val['dealer']; ?></td>
        	<td><?php echo $val['area']; ?></td>
        	<td><?php echo $val['branch']; ?></td>
        	<td><?php echo $val['destination']; ?></td>
        	<td><?php echo $val['assign_flag']; ?></td>
        	<td><?php echo $val['end_destination']; ?></td>
        	<td><?php echo $val['supplier']; ?></td>
        	<td><?php echo $val['status']; ?></td>
        	<td><?php echo $val['tam_do_number']; ?></td>
        	<td><?php echo $val['faktur']; ?></td>
        	<td><?php echo $val['tanggal_faktur']; ?></td>
        	<td><?php echo $val['tanggal_do']; ?></td>
        	<td><?php echo $val['tanggal_masuk']; ?></td>
        	<td><?php echo $val['penjualan_antar_cabang_dealer']; ?></td>
        	<td><?php echo $val['vin_code']; ?></td>
        	<td><?php echo $val['alokasi_unit']; ?></td>
        	<td><?php echo $val['nomor_spk']; ?></td>
        	<td><?php echo $val['nomor_bast']; ?></td>
        	<td><?php echo $val['status_bast']; ?></td>
        	<td><?php echo $val['status_afi']; ?></td>
        	<td></td>
		</tr>
        <?php } ?>
		</tbody>
<?php
	}
?>
	</table>
<?php    
    }

	if(!$_POST) 
    {
    	$query = "SELECT * FROM unit_stok
        	WHERE tanggal_do IS NOT NULL
            AND status_bast != 1";
        $stmt = $conn->prepare($query);
    	$stmt->execute();
    	$dataRow = $stmt->rowCount();
    
    	tampil($dataRow, $stmt);
    } 
	else if(isset($_POST)) 
    {
    	$mulai = $_POST['mulai'];
    	$sampai = $_POST['sampai'];
    
    	$query = "SELECT * FROM unit_stok 
        	WHERE produksi_date > '".$mulai."'
            AND produksi_date < '".$sampai."'";
        $cari = $conn->prepare($query);
    	$cari->execute();
    	$dataRow = $cari->rowCount();
    
    	tampil($dataRow, $cari);
    }
?> 
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
