<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%MRSWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
echo 'MRSWLK1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAWLK2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK2 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAWLK3%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK3 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%SAWLK4%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK4 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';

$sql = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2013%'
    AND `sa` LIKE '%TMSWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSWLK1 2013 : ';
var_dump($data[0]["COUNT('id')"]);
echo '<br>';
