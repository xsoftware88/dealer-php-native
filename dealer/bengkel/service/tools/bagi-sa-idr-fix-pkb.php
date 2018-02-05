<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";

$sql = "SELECT id, noka, sa
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%MRSIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
echo 'MRSIDR1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='MRSIDR1'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAIDR1'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAIDR2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR2 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAIDR2'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAIDR3%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR3 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAIDR3'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAIDR4%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR4 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAIDR4'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%SAIDR5%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'SAIDR5 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='SAIDR5'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%TMSIDR1%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSIDR1 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='TMSIDR1'
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
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'
    AND `sa` LIKE '%TMSIDR2%'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

echo 'TMSIDR2 2017 : ';
var_dump(count($data));

$i = 0;
foreach ($data as $val) {
    $sql = "SELECT id, noka, sa
        FROM service_data_pkb_full
        WHERE nomor_pkb LIKE '%IDR%'
        AND `noka` LIKE '%".$val['noka']."%'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data1 = $stmt->fetchAll();

    foreach ($data1 as $val1) {
        try {
            $sql = "UPDATE service_data_pkb_full
            SET sa='TMSIDR2'
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

