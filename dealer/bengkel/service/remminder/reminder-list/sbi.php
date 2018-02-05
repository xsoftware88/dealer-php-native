<?php
$i = 1;
$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));

//~ var_dump($sa != 'MRSIDR1');
if ($sa == 'MRSIDR1' || $sa == 'MRSWLK1') {
    //echo 'ok';
    if (strpos($sa, 'IDR') !== false) {
        $cabang = 'INDRAPURA';
    } else if (strpos($sa, 'WLK') !== false) {
        $cabang = 'WALIKOTA';
    } else {
        echo '<p class="text-center btn-danger">Maaf data untuk tipe ini hanya untuk MRS</p>';
        exit;
    }
} else {
    echo '<p class="text-center btn-danger">Maaf data untuk tipe ini hanya untuk MRS</p>';
    exit;
}

$sqlRemminderWithCount = "SELECT *
    FROM `service_data_sbi`
    WHERE cabang LIKE '%".$cabang."%'
    ORDER BY `service_data_sbi`.`tanggal_bast` DESC";

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
//~ var_dump($dataSiapRemainder);exit;
if (isset($dataSiapRemainder['data'])
&& !empty($dataSiapRemainder['data'])) {
    $dataSiapRemainderByKm = $dataSiapRemainder['data'];
    $totalData = count($dataSiapRemainderByKm);
    foreach ($dataSiapRemainderByKm as $valHistory) {
        echo "<tr>";
        echo "<td class=''>".$i++."</td>";
        echo "<td class='nopol'>"
            ."<a target='_blank' href='reminder-sbi.php?noka="
            .$valHistory['noka']."&id="
            .$valHistory['id']."'>"
            .$valHistory['noka']
            ."</a>"
            ."</td>";
        //echo "<td class='tipe'>".$valHistory['type']."<br />"
        //    .$valHistory['tahun']."</td>";
        echo "<td class='nama'>".$valHistory['nama']."<br />"
            .$valHistory['phone']."</td>";
        echo "<td class='alamat'>"
            .$valHistory['alamat']
            ."<br />---------------<br />"
            .$valHistory['kota']
            ."</td>";
        echo "<td class='km'></td>";
        echo "<td class='terakhir'></td>";
        echo "<td class='remminder'>"
            .$valHistory['status_remminder']
            ."<br />".$valHistory['tanggal_remminder']
            ."<br />".$valHistory['sa_remminder']
            ."</td>";
        echo "<td class='saran'></td>";
        echo "</tr>";
        //~ exit;
    }
    //~ echo '</tbody></table>';
    echo '<tr><td rowspan="10">';
    echo 'Total Data : '.$totalData;
    echo '</td></tr>';
}
