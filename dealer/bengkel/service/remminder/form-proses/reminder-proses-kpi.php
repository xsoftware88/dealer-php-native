<?php
//~ include '../../../conf.php';
$seninAwal  = date("Y-m-d",strtotime('monday this week'));
$seninAwal1 =  $seninAwal.' 00:00:00';
$seninAwal2 =  $seninAwal.' 23:59:59';

echo $seninAwal;

$qRKpi = 'select *
    from service_data_kpi_remminder
    where sa = "'.$sa.'"
    and tanggal_awal = "'.$seninAwal1.'"';

$stmt = $conn->prepare($qRKpi);
$stmt->execute();
$rowRKpi  = $stmt->rowCount();

if ($rowRKpi == 0) {
    echo '// insert new KPI';

    $sr = $_POST['selectRemminder'];
    if ($sr == 'Akurat Appointment'
    || $sr == 'Akurat Belum Ada Waktu'
    || $sr == 'Akurat Datang Sendiri'
    || $sr == 'Invalid Dijual'
    || $sr == 'Early KM Belum Sampai'
    || $sr == 'Early Reminder Lain Waktu'
    || $sr == 'Lost Masuk Bengkel Lain'
    ) {
        $dataRKpi[0]['tersambung']     = 1;
        $dataRKpi[0]['data_terkelola'] = 1;

        if ($sr == 'Akurat Appointment') {
            $dataRKpi[0]['appoitment'] = 1;
        } else if ($sr == 'Akurat Appointment') {
            $dataRKpi[0]['appoitment'] = 0;
        }

    } else {
        $dataRKpi[0]['tersambung']     = 0;
        $dataRKpi[0]['data_terkelola'] = 1;
        $dataRKpi[0]['appoitment']     = 0;
    }

    try {
        $sql = "INSERT INTO service_data_kpi_remminder
            (sa,
            tanggal_awal,
            simpan,
            jumlah_data,
            data_terkelola,
            tersambung,
            appoitment)
            VALUES (
            '".$sa."',
            '".$seninAwal1."',
            now(),
            '1500',
            '".$dataRKpi[0]['data_terkelola']."',
            '".$dataRKpi[0]['tersambung']."',
            '".$dataRKpi[0]['appoitment']."'
            )";
        //~ var_dump($sql);exit;

        $conn->exec($sql);
        $idKpi = $conn->lastInsertId();
    }
    catch (PDOException $e) {
        echo '<br /> Error : '.$e->getMessage();
        //break;
    }
} else if ($rowRKpi != 0) {
    echo '// update KPI';
    $dataRKpi = $stmt->fetchAll();

    $sr = $_POST['selectRemminder'];
    
    if ($sr == 'Akurat Appointment'
    || $sr == 'Akurat Belum Ada Waktu'
    || $sr == 'Akurat Datang Sendiri'
    || $sr == 'Invalid Dijual'
    || $sr == 'Early KM Belum Sampai'
    || $sr == 'Early Reminder Lain Waktu'
    || $sr == 'Lost Masuk Bengkel Lain'
    ) {
        $dataRKpi[0]['tersambung']     = $dataRKpi[0]['tersambung'];// + 1;
        $dataRKpi[0]['data_terkelola'] = $dataRKpi[0]['data_terkelola'];// + 1;

        if ($sr == 'Akurat Appointment') {
            $dataRKpi[0]['appoitment'] = $dataRKpi[0]['appoitment'] + 1;
        } else if ($sr == 'Akurat Appointment') {
            $dataRKpi[0]['appoitment'] = $dataRKpi[0]['appoitment'];
        }

    } else {
        $dataRKpi[0]['data_terkelola'] = $dataRKpi[0]['data_terkelola'];// + 1;
        $dataRKpi[0]['tersambung']     = $dataRKpi[0]['tersambung'];
        $dataRKpi[0]['appoitment']     = $dataRKpi[0]['appoitment'];
    }

    try {
        $sqlUpdateVehicle = "UPDATE service_data_kpi_remminder
            SET
            data_terkelola = '".$dataRKpi[0]['data_terkelola']."',
            tersambung = '".$dataRKpi[0]['tersambung']."',
            appoitment = '".$dataRKpi[0]['appoitment']."',
            simpan = now()
            WHERE sa = '".$sa."'
            AND tanggal_awal = '".$seninAwal1."'";
        //~ var_dump($sqlUpdateVehicle);exit;

        $stmt = $conn->prepare($sqlUpdateVehicle);
        $stmt->execute();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        break;
    }
}
