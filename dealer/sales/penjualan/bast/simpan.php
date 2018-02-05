<?php
include __DIR__ . "/../../head.php";

if(isset($_POST['simpan'])) {

if ($_POST['kota'] == 'Surabaya') {
		$rangeArea = 1;
} else if ($_POST['kota'] == 'Gresik' || $_POST['kota'] == 'Sidoarjo') {
		$rangeArea = 2;
} else {
		$rangeArea = 3;
}

$spk 			= $_POST['spk'];
$tglSpk		 	= $_POST['tgl_spk'];
$jenisPenjualan = $_POST['jenis'];
$leasing 		= $_POST['leasing'];
$nama 			= $_POST['nama_cust'];
$sales 			= $_POST['sales'];
$alamat 		= $_POST['alamat'];
$kota 			= $_POST['kota'];
$kecamatan 		= $_POST['kecamatan'];
$gesekan 		= $_POST['gesekan'];
$driver 		= $_POST['optionsRadios'];
$telp 			= $_POST['telp'];
$emailCust 		= $_POST['email'];
$npwp 			= $_POST['npwp'];
$noka 			= $_POST['noka'];
$nosin 			= $_POST['nosin'];
$bast 			= $_POST['bast'];
$tglBast 		= $_POST['tgl_bast'];
$tipe 			= $_POST['tipe'];
$warna 			= $_POST['warna'];
$tahun 			= $_POST['tahun'];
$nopol 			= $_POST['nopol'];
$variasi 		= $_POST['variasi'];
$spv 			= $_SESSION['username'];
$cabang 		= $_SESSION['cabang'];

$statement = "INSERT INTO sales_unit_kirim(
		driver,
		nomor_spk,
		tgl_spk,
		jenis_penjualan,
		leasing,
		nama_cust,
		alamat_cust,
		kota_cust,
		kecamatan_cust,
		gesekan,
		range_area,
		nomor_telp,
		email_cust,
		npwp_cust,
		spv,
		sales,
		noka,
		nosin,
		nomor_bast,
		tgl_bast,
		type_unit,
		warna_unit,
		tahun_unit,
		nopol_unit,
		variasi,
		tgl_simpan,
		tgl_update,
		cabang,
		user
	) VALUES (
		'".$driver."',
		'".$spk."',
		'".$tglSpk."',
		'".$jenisPenjualan."',
		'".$leasing."',
		'".$nama."',
		'".$alamat."',
		'".$kota."',
		'".$kecamatan."',
		'".$gesekan."',
		'".$rangeArea."',
		'".$telp."',
		'".$emailCust."',
		'".$npwp."',
		'".$spv."',
		'".$sales."',
		'".$noka."',
		'".$nosin."',
		'".$bast."',
		'".$tglBast."',
		'".$tipe."',
		'".$warna."',
		'".$tahun."',
		'".$nopol."',
		'".$variasi."',
		now(),
		now(),
		'".$cabang."',
		'".$spv."'
	);INSERT INTO point_sales(
		nama,
		nomor_spk,
		spv,
		tgl_simpan,
		tgl_update
	) VALUES(
		'".$sales."',
		'".$spk."',
		'".$spv."',
		now(),
		now()
	)";

$stmt = $conn->prepare($statement);
$stmt->execute();

if($stmt->rowCount() > 0) {
		echo '<script type="text/javascript">
		window.location = "index.php";
		</script>';
		}
}
