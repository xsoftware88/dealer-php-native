<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";
$i = 0;
//~ $sql = "SELECT * FROM view_pkb_full_sebelumnya ORDER BY noka1, tanggal_pkb1 ASC";
$sql = "SELECT 
	bast.noka, type_unit, tgl_bast, nama_cust, alamat_cust, kota_cust, nomor_telp, sales, spv, bast.cabang
    FROM sales_unit_kirim bast
    LEFT JOIN service_data_pkb_last pkb_last
    ON bast.noka = pkb_last.noka
    WHERE pkb_last.noka IS NULL";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();
$data     = $stmt->fetchAll();

echo '<pre>';
//var_dump(count($rowData));
var_dump($data);
