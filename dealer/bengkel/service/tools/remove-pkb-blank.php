<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";
$i = 0;
//~ $sql = "SELECT * FROM view_pkb_full_sebelumnya ORDER BY noka1, tanggal_pkb1 ASC";
$sql = "DELETE FROM service_data_pkb_full
		WHERE nomor_pkb = '' 
        AND noka = ''";

$stmt = $conn->prepare($sql);
$stmt->execute();

