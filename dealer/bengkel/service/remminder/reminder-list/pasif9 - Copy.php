<?php
$i = 1;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));

$sqlRemminderWithCount = "SELECT *
    FROM `view_remminder_with_count`
    WHERE sa LIKE '%IDR%'
    ORDER BY sa";
    //~ GROUP BY noka
    //~ ORDER BY `view_remminder_with_count`.`tanggal_service`";

$stmt = $conn->prepare($sqlRemminderWithCount);
$stmt->execute();
$rowRwc  = $stmt->rowCount();

if ($rowRwc != 0) {
    $dataRwc = $stmt->fetchAll();
    foreach ($dataRwc as $valRwc) {
        $tglAwal  = new DateTime($valRwc['tanggal_service']);
        $tglAkhir = new DateTime();
        $diff     = date_diff( $tglAwal, $tglAkhir );
        $jmlHari  = (int)$diff->days;

        $sqlDc = "SELECT id,nama,alamat
            FROM `service_cust` service_cust
            WHERE id = '".$valRwc['idCustomer']."'
            GROUP BY `service_cust`.`id`";

        $stmt = $conn->prepare($sqlDc);
        $stmt->execute();
        $rowDc = $stmt->rowCount();

        if ($rowDc != 0) {
            $dataDc = $stmt->fetchAll();
            $valRwc['nama']   = $dataDc[0]['nama'];
            $valRwc['alamat'] = $dataDc[0]['alamat'];

            $sqlDp = "SELECT phone
                FROM `service_cust_phone`
                WHERE service_cust = '".$dataDc[0]['id']."'
                AND service_vehicle = '".$valRwc['idVehicle']."'";

            $stmt = $conn->prepare($sqlDp);
            $stmt->execute();
            $rowDp = $stmt->rowCount();

            if ($rowDp != 0) {
                $dataDp = $stmt->fetchAll();

                $valRwc['nama']   = $dataDc[0]['nama'];
                $valRwc['alamat'] = $dataDc[0]['alamat'];

                $sqlDp = "SELECT phone
                    FROM `service_cust_phone`
                    WHERE service_cust = '".$dataDc[0]['id']."'
                    AND service_vehicle = '".$valRwc['idVehicle']."'";

                $stmt = $conn->prepare($sqlDp);
                $stmt->execute();
                $rowDp = $stmt->rowCount();

                if ($rowDp != 0) {
                    $dataDp = $stmt->fetchAll();

                    $valRwc['phone']   = $dataDp[0]['phone'];
                } else {
                    $valRwc['phone']   = "";
                }
            } else {
                $valRwc['nama']   = "";
                $valRwc['alamat'] = "";
                $valRwc['phone']   = "";
            }

            if ($jmlHari > 270) {
                $dataSiapRemainder['data'][] = $valRwc;
            }
        }
    }
}
// kurang data reminder yg null
if (isset($dataSiapRemainder['data'])
&& !empty($dataSiapRemainder['data'])) {
    $dataSiapRemainderByKm = $dataSiapRemainder['data'];
    $totalData = count($dataSiapRemainderByKm);
    var_dump(count($dataSiapRemainder['data']));
    //exit;
    foreach ($dataSiapRemainderByKm as $valHistory) {
        if ($valHistory['sa'] == 'SAIDR1') {
            $data9Bln['sa']['SAIDR1'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'SAIDR2') {
            $data9Bln['sa']['SAIDR2'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'SAIDR3') {
            $data9Bln['sa']['SAIDR3'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'SAIDR4') {
            $data9Bln['sa']['SAIDR4'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'SAIDR5') {
            $data9Bln['sa']['SAIDR5'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'TMSIDR1') {
            $data9Bln['sa']['TMSIDR1'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'TMSIDR2') {
            $data9Bln['sa']['TMSIDR2'][] = $valHistory['id'];
        }
        if ($valHistory['sa'] == 'MRSIDR1') {
            $data9Bln['sa']['MRSIDR1'][] = $valHistory['id'];
        }
    }
    echo'<br /> SAIDR1 : ';
    var_dump(count($data9Bln['sa']['SAIDR1']));
    echo'<br /> SAIDR2 : ';
    var_dump(count($data9Bln['sa']['SAIDR2']));
    echo'<br /> SAIDR3 : ';
    var_dump(count($data9Bln['sa']['SAIDR3']));
    echo'<br /> SAIDR4 : ';
    var_dump(count($data9Bln['sa']['SAIDR4']));
    echo'<br /> SAIDR5 : ';
    var_dump(count($data9Bln['sa']['SAIDR5']));
    echo'<br /> TMSIDR1 : ';
    var_dump(count($data9Bln['sa']['TMSIDR1']));
    echo'<br /> TMSIDR2 : ';
    var_dump(count($data9Bln['sa']['TMSIDR2']));
    echo'<br /> MRSIDR1 : ';
    var_dump(count($data9Bln['sa']['MRSIDR1']));
}
