<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%MRSWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
echo 'MRSWLK1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='MRSWLK1'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAWLK1'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAWLK2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK2 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAWLK2'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAWLK3%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK3 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAWLK3'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAWLK4%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAWLK4 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAWLK4'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%WLK%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%TMSWLK1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSWLK1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%WLK%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='TMSWLK1'
            WHERE id = '".$val1['id']."'";
            $conn->exec($sql);
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}
echo ' | ' . $i;
echo '<br>';
