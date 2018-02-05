<?php
$i = 1;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));

//~ var_dump($sa != 'MRSIDR1');
if ($sa == 'MRSIDR1' || $sa == 'MRSWLK1') {
    //echo 'ok';
    if (strpos($sa, 'IDR') !== false) {
        $cabang = 'IDR';
    } else if (strpos($sa, 'WLK') !== false) {
        $cabang = 'WLK';
    } else {
        echo '<p class="text-center btn-danger">Maaf data untuk tipe ini hanya untuk MRS</p>';
        exit;
    }
} else {
    echo '<p class="text-center btn-danger">Maaf data untuk tipe ini hanya untuk MRS</p>';
    exit;
}

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_pkb_last`
    WHERE nomor_pkb LIKE '%".$cabang."%'
    ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";

$stmt = $conn->prepare($sqlRemminderWithCount);
$stmt->execute();
$rowRwc  = $stmt->rowCount();

if ($rowRwc != 0) {
    $dataRwc = $stmt->fetchAll();
    foreach ($dataRwc as $valRwc) {
        $tglAwal  = new DateTime($valRwc['tanggal_pkb']);
        $tglAkhir = new DateTime();
        $diff     = date_diff( $tglAwal, $tglAkhir );
        $jmlHari  = (int)$diff->days;

        if ($jmlHari > 180 && $jmlHari < 270) {
            // select reminder by noka
            $sql  = "SELECT *
                    FROM service_data_remminder
                    WHERE noka = '".$valRwc['noka']."'
                    AND sa = '".$sa."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $rowData  = $stmt->rowCount();

            if ($rowData != 0) {
                $data = $stmt->fetchAll();
                foreach ($data as $val) {
                    if ($val['tanggal_remminder'] < $batasTgl) {
                        //var_dump($val);exit;
                        $valRwc['status_remminder']  = $val['status_remminder'];
                        $valRwc['tanggal_remminder'] = $val['tanggal_remminder'];
                        $valRwc['sa_remminder']      = $val['sa'];
                        $valRwc['keterangan']        = $val['keterangan'];

                        $dataSiapRemainder['data'][] = $valRwc;
                    }
                }
            } else {
                $valRwc['status_remminder']  = ' - ';
                $valRwc['tanggal_remminder'] = ' - ';
                $valRwc['sa_remminder']      = ' - ';
                $valRwc['keterangan']        = ' - ';

                $dataSiapRemainder['data'][] = $valRwc;
            }
        }
    }
}
// kurang data reminder yg null
//~ var_dump($dataSiapRemainder);exit;
if (isset($dataSiapRemainder['data'])
&& !empty($dataSiapRemainder['data'])) {
    $dataSiapRemainderByKm = $dataSiapRemainder['data'];
    $totalData = count($dataSiapRemainderByKm);
    foreach ($dataSiapRemainderByKm as $valHistory) {
        echo "<tr>";
        echo "<td class=''>".$i++."</td>";
        echo "<td class='nopol'>"
            ."<a target='_blank' href='reminder-view-history-bynoka.php?noka="
            .$valHistory['noka']."&id="
            .$valHistory['id']."'>"
            .$valHistory['nopol']."<br />"
            .$valHistory['noka']
            ."</a>"
            ."<br />".$valHistory['sa']
            ."</td>";
        //echo "<td class='tipe'>".$valHistory['type']."<br />"
        //    .$valHistory['tahun']."</td>";
        echo "<td class='nama'>".$valHistory['nama']."<br />"
            .$valHistory['phone']."</td>";
        echo "<td class='alamat'>".$valHistory['alamat']."</td>";
        echo "<td class='km'>".$valHistory['km']." <br /> ".$valHistory['km_selanjutnya']."</td>";
        echo "<td class='terakhir'>"
            .$valHistory['tanggal_pkb']
            ."<br />"
            .$valHistory['tanggal_selanjutnya']
            ."</td>";
        echo "<td class='remminder'>"
            .$valHistory['status_remminder']
            ."<br />".$valHistory['tanggal_remminder']
            ."<br />".$valHistory['sa_remminder']
            ."</td>";
        echo "<td class='saran'>"
            .$valHistory['saran']
            ."<br />---------------<br />"
            .$valHistory['keterangan']
            ."</td>";
        echo "</tr>";
        //~ exit;
    }
    //~ echo '</tbody></table>';
    echo '<tr><td rowspan="10">';
    echo 'Total Data : '.$totalData;
    echo '</td></tr>';
}
