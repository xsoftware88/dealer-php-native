<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";
$i = 0;
//~ $sql = "SELECT * FROM view_pkb_full_sebelumnya ORDER BY noka1, tanggal_pkb1 ASC";
$sql = "SELECT * FROM service_data_pkb_last ORDER BY tanggal_pkb ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();

var_dump(count($rowData));

if ($rowData != 0) {
    $data = $stmt->fetchAll();
    foreach ($data as $val) {

        $sqlFull = "SELECT * FROM service_data_pkb_full
            WHERE nomor_pkb = '".$val['nomor_pkb']."'
            ORDER BY noka, tanggal_pkb ASC";

        $stmt = $conn->prepare($sqlFull);
        $stmt->execute();
        $rowDataFull  = $stmt->rowCount();

        if ($rowDataFull != 0) {
            $dataFull = $stmt->fetchAll();
            foreach ($dataFull as $valFull) {
                // update pkb
                $sql = "UPDATE service_data_pkb_last
                    SET
                    tanggal_sebelumnya='".$valFull['tanggal_sebelumnya']."',
                    km_sebelumnya='".$valFull['km_sebelumnya']."',
                    tanggal_selanjutnya='".$valFull['tanggal_selanjutnya']."',
                    km_selanjutnya='".$valFull['km_selanjutnya']."'
                    WHERE nomor_pkb = '".$val['nomor_pkb']."'";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $i++;
            }
        }

    }
}
echo $i;
