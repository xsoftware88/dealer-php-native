<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%MRSIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
echo 'MRSIDR1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAIDR2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR2 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAIDR3%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR3 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAIDR4%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR4 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAIDR5%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR5 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%TMSIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSIDR1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%TMSIDR2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSIDR2 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';
