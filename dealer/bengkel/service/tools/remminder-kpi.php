<?php
//include __DIR__ . '/../../../../conf/conf.php';

//~ echo '<pre>';
//echo '<br>';
$awal = date('01-M-Y');
//echo '&nbsp;&nbsp;&nbsp; Awal Periode &nbsp;: ' . $awal . '<br>';

$date  = strtotime($awal);
$date  = date('d-M-Y',strtotime('+1 month',$date));
//~ echo $date . '<br>';

$akhir = date('d-M-Y', strtotime("next sunday", strtotime($date)));
//echo '&nbsp;&nbsp;&nbsp; Akhir Periode : ' . $akhir . '<br>';
//echo '<br>';

$awal  = date('Y-m-d 00:00:00', strtotime($awal));
$akhir = date('Y-m-d 23:59:59', strtotime($akhir));

$sql  = "SELECT *
    FROM service_data_remminder
    WHERE tanggal_remminder BETWEEN '".$awal."'
    AND '".$akhir."'
    AND sa LIKE '%WLK%'
    ORDER BY status_remminder ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();

$i = 0;

if ($rowData != 0) {
    $data = $stmt->fetchAll();
    //~ var_dump($data[0]);
    foreach ($data as $val) {
        $sr = $val['status_remminder'];

        if ($val['sa'] == 'SAWLK1') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAWLK2') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAWLK3') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAWLK4') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'MRSWLK1') {
            include 'check-data/remminder-kpi.php';
        }
    }
    //echo '<br>' . $i;
}//*/

$sql  = "SELECT *
    FROM service_data_remminder
    WHERE tanggal_remminder BETWEEN '".$awal."'
    AND '".$akhir."'
    AND sa LIKE '%IDR%'
    ORDER BY status_remminder ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();
$i = 0;
if ($rowData != 0) {
    $data = $stmt->fetchAll();
    //~ var_dump($data[0]);
    foreach ($data as $val) {
        $sr = $val['status_remminder'];
        if ($val['sa'] == 'SAIDR1') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAIDR2') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAIDR3') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAIDR4') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'SAIDR5') {
            include 'check-data/remminder-kpi.php';
        }
        else if ($val['sa'] == 'MRSIDR1') {
            include 'check-data/remminder-kpi.php';
        }//*/
    }
}


foreach ($dataRKpi as $keySa => $valSa) {
    if (!isset($dataRKpi[$keySa]['appoitment'])) {
        $dataRKpi[$keySa]['appoitment'][] = 0;
        $valSa['appoitment'][] = 0;
    }
    foreach ($valSa as $key => $val) {
        $data = array_count_values($dataRKpi[$keySa][$key]);
        if (!isset($data[1])) {
            $data[1] = 0;
        }
        $dataRKpi[$keySa][$key] = $data[1];
    }
}

//echo '<pre>';
//~ var_dump($dataRKpi);
foreach ($dataRKpi as $keySa => $valSa) {
    //var_dump($keySa);
    //~ var_dump($valSa);

    $sql  = "SELECT *
        FROM service_temp_kpi_remminder
        WHERE periode_awal >= '".$awal."'
        AND periode_akhir <= '".$akhir."'
        AND sa = '".$keySa."'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rowData  = $stmt->rowCount();
    $i = 0;

    //~ var_dump($rowData);
    if ($rowData == 0) {
        include 'check-data/remminder-kpi-last-pkb.php';
        try {
            $sql = "INSERT INTO service_temp_kpi_remminder
                (sa,
                periode_awal,
                periode_akhir,
                jumlah_data,
                terkelola,
                tersambung,
                appoitment)
                VALUES (
                '".$keySa."',
                '".$awal."',
                '".$akhir."',
                '".$i."',
                '".$valSa['data_terkelola']."',
                '".$valSa['tersambung']."',
                '".$valSa['appoitment']."')";
            //~ var_dump($sql);exit;

            $conn->exec($sql);
            $idKpi = $conn->lastInsertId();
        }
        catch (PDOException $e) {
            echo '<br /> Error : '.$e->getMessage();
            //break;
        }
    } else {
        $data = $stmt->fetchAll();
        include 'check-data/remminder-kpi-last-pkb.php';
        try {
            $sqlUpdateVehicle = "UPDATE service_temp_kpi_remminder
                SET
                jumlah_data = '".$i."',
                terkelola = '".$valSa['data_terkelola']."',
                tersambung = '".$valSa['tersambung']."',
                appoitment = '".$valSa['appoitment']."'
                WHERE sa = '".$keySa."'
                AND periode_awal = '".$awal."'";
            //~ var_dump($sqlUpdateVehicle);exit;

            $stmt = $conn->prepare($sqlUpdateVehicle);
            $stmt->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }//*/
}
