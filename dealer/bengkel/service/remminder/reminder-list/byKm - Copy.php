<?php
$i = 1;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));
echo "<pre>";

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_pkb_last`
    WHERE sa = '".$sa."'
    AND noka = 'MHF53BK3034001722'";
    //AND noka = 'MHFFMRGK35K043440'";
    //AND noka = 'MHF53BK3034001722'";
    //AND noka = 'MHFKT9F33E6009810'";
    //AND noka = 'MHKM1BA3JDJ001808'";
    //AND noka = 'MHFFMRGK35K043440'";

$stmt = $conn->prepare($sqlRemminderWithCount);
$stmt->execute();
$rowRwc  = $stmt->rowCount();

if ($rowRwc != 0) {
    $dataRwc = $stmt->fetchAll();
    foreach ($dataRwc as $valRwc) {
        $stdrKM   = 10000;
        $tglAwal  = new DateTime($valRwc['tanggal_pkb']);
        $tglAkhir = new DateTime();
        $diff     = date_diff( $tglAwal, $tglAkhir );
        $jmlHari  = (int)$diff->days;

        if (is_null($valRwc['tanggal_sebelumnya'])) {
            $nextJmlHari = ceil('180');
            $kmPerhari = 56;

            $kmEstimasi   = $kmPerhari * $jmlHari;

            //~ $kmSebelumnya = (int)$valRwc['km'];
            //~ $selisihKm    = (int)$valRwc['km'] - $kmEstimasi;
            $kmSebelumnya = (int)$valRwc['km'] - $kmEstimasi;
            $selisihKm    = (int)$valRwc['km'] - $kmSebelumnya;

            $kmPerhari    = $selisihKm / $jmlHari;;
            $kmNext       = $kmSebelumnya + $kmEstimasi;

            $tglNext      = date('Y-m-d', strtotime('+'.$nextJmlHari.' days', strtotime($tglAkhir->format("Y-m-d"))));
        } else {
            if ($valRwc['tanggal_sebelumnya'] == $valRwc['tanggal_pkb'] && $valRwc['km'] > 1000) {
                $dataTglAwal  = new DateTime($valRwc['tanggal_sebelumnya']);
                $dataTglAwal  = date('Y-m-d', strtotime('-30 days', strtotime($dataTglAwal->format("Y-m-d"))));
                $dataTglAwal  = new DateTime($dataTglAwal);

                $dataTglAkhir = new DateTime($valRwc['tanggal_pkb']);

                $diff         = date_diff( $dataTglAwal, $dataTglAkhir );
                $dataJmlHari  = (int)$diff->days;

                $kmSebelumnya = (int)$valRwc['km'] - 1000;
                $selisihKm    = (int)$valRwc['km'] - $kmSebelumnya;
                $kmPerhari    = $selisihKm / $dataJmlHari;

                $kmEstimasi   = $kmPerhari * $jmlHari;
                $kmNext       = $kmSebelumnya + $kmEstimasi;

                $kmRataRata   = $stdrKM / $selisihKm;
                $nextJmlHari  = $dataJmlHari * $kmRataRata;

                $tglNext      = date('Y-m-d', strtotime('+'.$nextJmlHari.' days', strtotime($dataTglAkhir->format("Y-m-d"))));
            } else if ((int)$valRwc['km_sebelumnya'] > (int)$valRwc['km']) {
                $dataTglAwal  = new DateTime($valRwc['tanggal_sebelumnya']);
                $dataTglAwal  = date('Y-m-d', strtotime('-30 days', strtotime($dataTglAwal->format("Y-m-d"))));
                $dataTglAwal  = new DateTime($dataTglAwal);

                $dataTglAkhir = new DateTime($valRwc['tanggal_pkb']);

                $diff         = date_diff( $dataTglAwal, $dataTglAkhir );
                $dataJmlHari  = (int)$diff->days;

                $kmSebelumnya = (int)$valRwc['km'] - 1000;
                $selisihKm    = (int)$valRwc['km'] - $kmSebelumnya;
                $kmPerhari    = $selisihKm / $dataJmlHari;

                $kmEstimasi   = $kmPerhari * $jmlHari;
                $kmNext       = $kmSebelumnya + $kmEstimasi;

                $kmRataRata   = $stdrKM / $selisihKm;
                $nextJmlHari  = $dataJmlHari * $kmRataRata;

                $tglNext      = date('Y-m-d', strtotime('+'.$nextJmlHari.' days', strtotime($dataTglAkhir->format("Y-m-d"))));
            } else {
                $dataTglAwal  = new DateTime($valRwc['tanggal_sebelumnya']);
                $dataTglAkhir = new DateTime($valRwc['tanggal_pkb']);
                $diff         = date_diff( $dataTglAwal, $dataTglAkhir );
                $dataJmlHari  = (int)$diff->days;

                $kmSebelumnya = (int)$valRwc['km'];
                $selisihKm    = (int)$valRwc['km'] - (int)$valRwc['km_sebelumnya'];
                $kmPerhari   = $selisihKm / $dataJmlHari;//*/

                $kmEstimasi   = $kmPerhari * $jmlHari;
                $kmNext       = $kmSebelumnya + $kmEstimasi;

                $kmRataRata   = $stdrKM / $selisihKm;
                $nextJmlHari  = $dataJmlHari * $kmRataRata;
                $nextJmlHari  = ceil($nextJmlHari);

                $tglNext      = date('Y-m-d', strtotime('+'.$nextJmlHari.' days', strtotime($dataTglAkhir->format("Y-m-d"))));
            }
        }

        var_dump($nextJmlHari);
        var_dump($kmSebelumnya);
        var_dump($selisihKm);
        var_dump($kmNext);
        var_dump($tglNext);
        exit;

        if ($nextKm >= 10000 && $jmlHari < 180) {
            $dataSiapRemainder['data'][] = $valRwc;
        }
        //else {$dataSiapRemainder['xx'][] = $valRwc;}
        /*else if ($kmRataRata <= 10000) {
            $dataSiapRemainder['byKm1'][] = $valRwc;
        }*/
    }
}
// kurang data reminder yg null
//~ var_dump(count($dataSiapRemainder['xx']));exit;
if (isset($dataSiapRemainder['data'])
&& !empty($dataSiapRemainder['data'])) {
    $dataSiapRemainderByKm = $dataSiapRemainder['data'];
    $totalData = count($dataSiapRemainderByKm);
    foreach ($dataSiapRemainderByKm as $valHistory) {
        echo "<tr>";
        echo "<td class=''>".$i++."</td>";
        echo "<td class='nopol'>"
            ."<a target='_blank' href='reminder-view-history-bynoka.php?noka="
            .$valHistory['noka']."&countid="
            .$valHistory['idCount']."'>"
            .$valHistory['nopol']."<br />"
            .$valHistory['noka']
            ."</a>"
            ."<br />".$valHistory['sa']
            ."</td>";
        echo "<td class='tipe'>".$valHistory['type']."<br />"
            .$valHistory['tahun']."</td>";
        echo "<td class='nama'>".$valHistory['nama']."<br />"
            .$valHistory['phone']."</td>";
        echo "<td class='alamat'>".$valHistory['alamat']."</td>";
        echo "<td class='km'>".$valHistory['km_sebelumnya']."</td>";//." / ".$valHistory['km_rata_rata']."</td>";
        echo "<td class='terakhir'>"
            .$valHistory['tanggal_service']
            ."<br />"
            .$valHistory['tanggal_next_service']
            ."</td>";
        echo "<td class='remminder'>".$valHistory['status_remminder'].
            "<br />".$valHistory['tanggal_remminder'].
            "<br />".$valHistory['sa_remminder']."</td>";
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
