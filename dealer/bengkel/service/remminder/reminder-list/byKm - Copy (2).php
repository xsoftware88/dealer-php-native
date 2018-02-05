<?php
$i        = 1;
$kmStd    = 10000;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));
//~ echo "<pre>";

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_pkb_last`
    WHERE sa = '".$sa."'
    ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";
    //AND noka = 'MHF53BK3034001722'";
    //AND noka = 'MHFM1BA3JSK216912'";
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
        if (is_null($valRwc['tanggal_sebelumnya'])) {
            $selisihHari   = ceil('180');
            $kmPerhari     = 56;
            $tglAwal       = new DateTime($valRwc['tanggal_pkb']);
            $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
            $tglSebelumnya = new DateTime($tglSebelumnya);

            $kmPerhari     = (int)$valRwc['km'] / $selisihHari;
            $kmSekarang    = (int)$valRwc['km'];
            $kmSebelumnya  = (int)$valRwc['km'] - $kmStd;
            $kmNext        = (int)$valRwc['km'] + $kmStd;

            $tglNext      = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
        } else {
            if ($valRwc['tanggal_sebelumnya'] == $valRwc['tanggal_pkb'] && $valRwc['km'] > 1000) {
                $selisihHari   = ceil('30');
                $kmPerhari     = 333.333;
                $tglAwal       = new DateTime($valRwc['tanggal_pkb']);
                $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
                $tglSebelumnya = new DateTime($tglSebelumnya);

                $kmPerhari     = (int)$valRwc['km'] / $selisihHari;
                $kmSekarang    = (int)$valRwc['km'];
                $kmSebelumnya  = (int)$valRwc['km'] - $kmStd;
                $kmNext        = (int)$valRwc['km'] + $kmStd;


                $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
            } else if ((int)$valRwc['km_sebelumnya'] > (int)$valRwc['km']) {
                $selisihHari   = ceil('180');
                $kmPerhari     = 56;
                $tglAwal       = new DateTime($valRwc['tanggal_pkb']);
                $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
                $tglSebelumnya = new DateTime($tglSebelumnya);

                $kmPerhari     = (int)$valRwc['km'] / $selisihHari;
                $kmSekarang    = (int)$valRwc['km'];
                $kmSebelumnya  = (int)$valRwc['km'] - $kmStd;
                $kmNext        = (int)$valRwc['km'] + $kmStd;


                $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));
            } else {
                $tglAwal       = new DateTime($valRwc['tanggal_pkb']);
                $tglSebelumnya = new DateTime($valRwc['tanggal_sebelumnya']);
                $diff          = date_diff( $tglAwal, $tglSebelumnya );
                $selisihHari   = (int)$diff->days;

                $tglAwal       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));

                $selisihKm     = (int)$valRwc['km'] - (int)$valRwc['km_sebelumnya'];
                $kmSekarang    = (int)$valRwc['km'] + (int)$selisihKm;

                if ( ceil((int)$selisihKm) == 0 ){$selisihKm = 1;}
                $kmPerhari     = ceil((int)$kmStd ) / ceil((int)$selisihKm);

                //~ $tglEstimasi   = ceil((int)$kmPerhari) * (int)$selisihHari;
                //~ $tglEstimasi   = ceil($tglEstimasi);
                $tglEstimasi   = ceil((int)$selisihKm) / (int)$selisihHari;
                $tglEstimasi   = ceil((int)$kmStd) / (int)$tglEstimasi;

                $kmEstimasi    = (int)$kmStd - (int)$selisihKm;
                $kmSebelumnya  = (int)$valRwc['km_sebelumnya'];
                $kmNext        = (int)$kmSekarang + ceil($kmEstimasi);

                $tglNext       = date('Y-m-d', strtotime('+'.$tglEstimasi.' days', strtotime($tglAwal)));
            }
        }

        if ($selisihKm >= 10000 && $selisihHari < 180) {
            $valRwc["tanggal_selanjutnya"] = $tglNext;
            $valRwc["km_selanjutnya"]      = $kmNext;

            $dataSiapRemainder['data'][] = $valRwc;
            //~ var_dump($selisihKm);
            //~ var_dump($kmStd);
            //~ var_dump($kmPerhari);
            //~ exit;
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
            //~ .$valHistory['status_remminder']
            //~ ."<br />".$valHistory['tanggal_remminder']
            //~ ."<br />".$valHistory['sa_remminder']
            ."</td>";
        echo "<td class='saran'>"
            .$valHistory['saran']
            ."<br />---------------<br />"
            //.$valHistory['keterangan']
            ."</td>";
        echo "</tr>";
        //~ exit;
    }
    //~ echo '</tbody></table>';
    echo '<tr><td rowspan="10">';
    echo 'Total Data : '.$totalData;
    echo '</td></tr>';
}
