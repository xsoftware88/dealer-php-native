<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";

$sqlVehicleHistory = "SELECT COUNT('id')
    FROM service_data_pkb_last
    WHERE nomor_pkb LIKE '%IDR%'
    AND `tanggal_pkb` LIKE '%2017%'";

$stmt = $conn->prepare($sqlVehicleHistory);
$stmt->execute();
$dataVehicleHistory = $stmt->fetchAll();

$jml = $dataVehicleHistory[0]["COUNT('id')"];
$x   = floor($jml / 8);
//~ var_dump($x);exit;

$i8  = $jml - $x;
$i7  = $i8 - $x;
$i6  = $i7 - $x;
$i5  = $i6 - $x;
$i4  = $i5 - $x;
$i3  = $i4 - $x;
$i2  = $i3 - $x;
$i1  = $i2 - $x;

echo $i1 . ' 1- |  ';
echo $i2 . ' 2- | ';
echo $i3 . ' 3- | ';
echo $i4 . ' 4- | ';
echo $i5 . ' 5- | ';
echo $i6 . ' 6- | ';
echo $i7 . ' 7- | ';
echo $i8 . ' 8- | ';
echo $jml . ' jml- ';

//~ var_dump($x);
//~ exit;
echo "<br>========<br>";


if ($i1 != 0) {
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT 0, $i1";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - MRSWLK1 0 - ' . $i1 . '<br />';

    if ($dataVehicle == 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='MRSWLK1'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i1 = $i1+1;
    $sqlVehicleHistory1 = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i1, $i2";

    $stmt = $conn->prepare($sqlVehicleHistory1);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - SAIDR1 '.$i1.' - ' . $i2 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='SAIDR1'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i2 = $i2+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i2, $i3";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - SAIDR2 '.$i2.' - ' . $i3 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='SAIDR2'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i3 = $i3+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i3, $i4";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - SAIDR3 '.$i3.' - ' . $i4 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='SAIDR3'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i4 = $i4+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i4, $i5";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - SAIDR4 '.$i4.' - ' . $i5 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='SAIDR4'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i5 = $i5+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i5, $i6";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - SAIDR5 '.$i5.' - ' . $i6 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='SAIDR5'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i6 = $i6+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i6, $i7";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - TMSIDR1 '.$i6.' - ' . $i7 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='TMSIDR1'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i7 = $i7+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i7, $i8";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - TMSIDR2 '.$i7.' - ' . $i8 . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='TMSIDR2'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }

    $i8 = $i8+1;
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT $i8, $jml";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicle = $stmt->rowCount();

    echo $dataVehicle . ' - MRSIDR1 '.$i8.' - ' . $jml . '<br />';

    if ($dataVehicle != 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='MRSIDR1'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }
}

if ($i1 == 0) {
    $sqlVehicleHistory = "SELECT id,sa
        FROM service_data_pkb_last
        WHERE nomor_pkb LIKE '%IDR%'
        AND `tanggal_pkb` LIKE '%2017%' LIMIT 0, $i1";

    $stmt = $conn->prepare($sqlVehicleHistory);
    $stmt->execute();
    $dataVehicleHistory = $stmt->fetchAll();

    var_dump($dataVehicleHistory);
    $dataVehicle = $stmt->rowCount();

    if ($rowVehiclePartSelect == 0) {
        $tmpVehicle = $stmt->fetchAll();
        foreach ($tmpVehicle as $dataVH){
            try {
                $sql = "UPDATE service_data_pkb_last
                SET sa='MRSIDR1'
                WHERE id = '".$dataVH['id']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }
}
