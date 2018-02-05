<?php

// cek stall +- 1 jam kosong atau tidak

$sql  = "SELECT *
    FROM service_data_appoitment
    WHERE noka = '".$_POST['noka']."'";
    //AND DATE(janji_kedatangan) = '".$now."'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();

if ($rowData == 0) {
    echo 'data baru';
    try {
        $sqlAppoitment = "INSERT INTO service_data_appoitment
            (nomor_pkb,
            nopol,
            noka,
            pembawa,
            tlp_pembawa,
            keluhan,
            tipe_order,
            stall,
            opl,
            service_plus,
            sa,
            janji_kedatangan,
            janji_penyerahan,
            user_update,
            tanggal_update,
            user_input,
            tanggal_simpan)
            VALUES (
            '-',
            '".$_POST['nopol']."',
            '".$_POST['noka']."',
            '".$_POST['pembawa']."',
            '".$_POST['tlpPembawa']."',
            '".$_POST['keluhan']."',
            '".$_POST['tipeOrder']."',
            '".$_POST['stall']."',
            '".$_POST['opl']."',
            '".$_POST['servicePlus']."',
            '".$sa."',
            '".$_POST['datang']."',
            '".$_POST['penyerahan']."',
            '".$sa."',
            now(),
            '".$sa."',
            now())";
            //var_dump($sqlAppoitment);exit;
        $conn->exec($sqlAppoitment);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        break;
    }
} else {
    echo 'data update';
    try {
        $sqlUpdateAppoitment = "UPDATE service_data_appoitment
            SET
            nomor_pkb = '-',
            nopol = '".$_POST['nopol']."',
            noka = '".$_POST['noka']."',
            pembawa = '".$_POST['pembawa']."',
            tlp_pembawa = '".$_POST['tlpPembawa']."',
            keluhan= '".$_POST['keluhan']."',
            tipe_order = '".$_POST['tipeOrder']."',
            stall = '".$_POST['stall']."',
            opl = '".$_POST['opl']."',
            service_plus = '".$_POST['servicePlus']."',
            sa = '".$sa."',
            janji_kedatangan = '".$_POST['datang']."',
            janji_penyerahan = '".$_POST['penyerahan']."',
            user_update = '".$sa."',
            tanggal_update = now()
            WHERE noka = '".$_POST['noka']."'";
            //var_dump($sqlAppoitment);exit;

        $stmt = $conn->prepare($sqlUpdateAppoitment);
        $stmt->execute();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        break;
    }
}
