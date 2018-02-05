<?php
include '../../../../conf/conf.php';

session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
}
$i        = 1;
$kmStd    = 10000;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));
//~ echo "<pre>";

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_pkb_last`
    WHERE sa = '".$sa."'
    AND nopol LIKE '%".$_POST['nopol']."%'
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
        $dataSiapRemainder['data'][] = $valRwc;
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
