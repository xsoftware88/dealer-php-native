<?php
include __DIR__ . '../../../../conf/conf.php';
include __DIR__ . '/../tools/remminder-kpi.php';

session_start();
if (!empty($_SESSION['username'])) {
    $sa = $_SESSION['username'];
    include __DIR__ . '../../../menu/reminder.php';
    ?>

    <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dealer/asset/css/normalize.css"/>
    <style>
        tbody {
            height: auto;
            display: inline;
        }
        .table thead th, .table tbody td {
            width: 50em;
        }
    </style>
    <?php
} else {
    include __DIR__ . '../../../asset/asset.php';
}


//~ echo '<pre>';
echo '<br>';
$awal = date('01-M-Y');
echo '&nbsp;&nbsp;&nbsp; Awal Periode &nbsp;: ' . $awal . '<br>';

$date  = strtotime($awal);
$date  = date('d-M-Y',strtotime('+1 month',$date));

$akhir = date('d-M-Y', strtotime("next sunday", strtotime($date)));
echo '&nbsp;&nbsp;&nbsp; Akhir Periode : ' . $akhir . '<br>';
echo '<br>';

$awal  = date('Y-m-d 00:00:00', strtotime($awal));
$akhir = date('Y-m-d 23:59:59', strtotime($akhir));

$sql  = "SELECT *
    FROM service_temp_kpi_remminder
    WHERE periode_awal >= '".$awal."'
    AND periode_akhir <= '".$akhir."'
    ORDER BY appoitment DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();
$i = 0;
if ($rowData != 0) {
    $data = $stmt->fetchAll();

    echo '<table id="reset" class="table table-striped table-responsive">';
    echo '<thead>';
    echo '<tr>';
    echo '<th> PIC </th>';
    echo '<th> TOTAL PKB </th>';
    echo '<th> TERKELOLA </th>';
    echo '<th> TERSAMBUNG </th>';
    echo '<th> APPOITMENT </th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($data as $key => $val) {
        echo '<tr>';
        echo '<td> ' . $val['sa'] . ' </td>';
        echo '<td> ' . $val['jumlah_data'] . ' </td>';
        echo '<td> ' . $val['terkelola'] . ' </td>';
        echo '<td> ' . $val['tersambung'] . ' </td>';
        echo '<td> ' . $val['appoitment'] . ' </td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

}
