<?php
include '../../../conf/conf.php';

session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    include '../../menu/reminder.php';
}
?>

<style>
    table {font-size: 12px;}
    table, thead, tr {
        display: block;
        width: 100%;
    }
    tbody {
        overflow: auto;
        height: 400px;
        display: block;
    }
    .nopol {width: 158px;}
    .tipe {width: 85px;}
    .nama {width: 200px;}
    .alamat {width: 200px;}
    .saran {width: 200px;}
    .km {width: 60px;}
    .terakhir {width: 100px;}
    .next {width: 100px;}
    .remminder {width: 200px;}
    .imgCenter {
        margin: auto;
        display: block;
        text-align: center;
        text-align: -webkit-center;
    }
</style>
<?php

$sqlAppoitment = "SELECT *
    FROM `service_data_kpi_remminder`
    WHERE sa = '".$sa."'";

$stmt = $conn->prepare($sqlAppoitment);
$stmt->execute();
$countAppoitment = $stmt->rowCount();

if ($countAppoitment != 0)  {
?>
<table class="table table-striped table-responsive">
  <thead>
      <tr>
        <th class='nopol'>PERIODE</th>
        <th class='nopol'>PIC</th>
        <th class='nopol'>DATA TERSAMBUNG</th>
        <th class='nopol'>APPOINTMENT</th>
        <th class='nopol'>DATA TERKELOLA</th>
      </tr>
  </thead>
  <tbody>
      <?php
        $dataAppoitment = $stmt->fetchAll();

        foreach ($dataAppoitment as $val) {
            //~ var_dump($val);exit;
            echo "<tr>";
            echo "<td class='nopol'>".$val['tanggal_awal']."</td>";
            echo "<td class='nopol'>".$val['sa']."</td>";
            echo "<td class='nopol'>".$val['tersambung']."</td>";
            echo "<td class='nopol'>".$val['appoitment']."</td>";
            echo "<td class='nopol'>".$val['data_terkelola']."</td>";
            echo "</tr>";
        }
      ?>
  </tbody>
</table>
<?php
} else {
    echo "Maaf anda belum ada KPI";
}
