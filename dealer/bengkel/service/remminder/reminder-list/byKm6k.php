<?php
$i        = 1;
$kmStd    = 10000;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));
//~ echo "<pre>";

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_pkb_last`
    WHERE sa = '".$sa."'
    ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";
    //AND noka = 'MHFE2CJ3JDK066165'";
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
        if ((is_null($valRwc['tanggal_sebelumnya'])
        || $valRwc['tanggal_sebelumnya'] == "0000-00-00")
        &&(is_null($valRwc['tanggal_selanjutnya'])
        || $valRwc['tanggal_selanjutnya'] == "0000-00-00")) {
            // tanggal_sebelumnya tdk ada dan tanggal_selanjutnya tdk ada
            $tglAkhir      = $valRwc['tanggal_pkb'];
            $kmAkhir       = $valRwc['km'];

            $selisihHari   = ceil('180');
            $kmPerhari     = 56;

            $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAkhir)));

            $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAkhir)));

            $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
            $kmSebelumnya  = (int)$kmAkhir - $kmEstimasi;

            $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
            $kmNext        = (int)$kmAkhir + $kmEstimasi;

            $selisihKm     = (int)$kmAkhir - $kmSebelumnya;
        } else {
                //akhir krn tanggal_selanjutnya tdk ada
                if ((is_null($valRwc['tanggal_sebelumnya'])
                || $valRwc['tanggal_sebelumnya'] == "0000-00-00")
                && !is_null($valRwc['tanggal_selanjutnya'])) {
                    //awal krn tanggal_sebelumnya tdk ada
                    $tanggalAwal  = $valRwc['tanggal_pkb'];
                    $tanggalAKhir = $valRwc['tanggal_selanjutnya'];
                    $tanggalPkb   = $valRwc['tanggal_pkb'];
                    $kmAwal       = $valRwc['km'];
                    $kmAkhir      = $valRwc['km_selanjutnya'];
                }
                if (!is_null($valRwc['tanggal_sebelumnya'])
                && (is_null($valRwc['tanggal_selanjutnya'])
                || $valRwc['tanggal_selanjutnya'] == "0000-00-00")) {
                    //akhir krn tanggal_selanjutnya tdk ada
                    $tanggalAwal  = $valRwc['tanggal_sebelumnya'];
                    $tanggalAKhir = $valRwc['tanggal_pkb'];
                    $tanggalPkb   = $valRwc['tanggal_pkb'];
                    $kmAwal       = $valRwc['km_sebelumnya'];
                    $kmAkhir      = $valRwc['km'];
                } else {
                    $tanggalAwal  = $valRwc['tanggal_sebelumnya'];
                    $tanggalAKhir = $valRwc['tanggal_pkb'];
                    $tanggalPkb   = $valRwc['tanggal_pkb'];
                    $kmAwal       = $valRwc['km_sebelumnya'];
                    $kmAkhir      = $valRwc['km'];
                }

                if ($tanggalAwal == $tanggalPkb && $kmAwal > 1000 && $kmAwal < 10000) {
                    $selisihHari   = ceil('30');
                    $kmPerhari     = 333.333;

                    $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tanggalAKhir)));

                    $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                    $kmNext        = (int)$kmAkhir + $kmEstimasi;
                    $selisihKm     = (int)$kmNext - $kmAkhir;
                } else if ((int)$kmAwal > (int)$kmAkhir) {
                    $selisihHari   = ceil('180');
                    $kmPerhari     = 56;

                    $selisihKm     = (int)$kmAwal - $kmAkhir;
                } else {
                    $tglAwal       = new DateTime($tanggalAwal);
                    $tglAkhir      = new DateTime($tanggalAKhir);
                    $diff          = date_diff( $tglAwal, $tglAkhir );

                    $selisihHari   = (int)$diff->days;
                    $selisihKm     = (int)$kmAkhir - $kmAwal;
                }
        }

        if ($valRwc['km'] > 60000) {
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
