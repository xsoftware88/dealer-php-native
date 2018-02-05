<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";
$i    = 0;
//~ $sql  = "SELECT * FROM view_pkb_full_selanjutnya WHERE `noka1` LIKE 'ACA365002190' ORDER BY noka1, tanggal_pkb1 ASC";
$sql  = "SELECT * FROM view_pkb_full_selanjutnya ORDER BY noka1, tanggal_pkb1 ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();

var_dump(count($rowData));

if ($rowData != 0) {
    $data = $stmt->fetchAll();
    foreach ($data as $val) {
        // update pkb
        /*if (!is_null($val['tanggal_pkb2'])) {
            $sql = "UPDATE service_data_pkb_full
                SET
                tanggal_sebelumnya='".$val['tanggal_pkb1']."',
                km_sebelumnya='".$val['km1']."'
                WHERE id = '".$val['id2']."'
                AND noka = '".$val['noka2']."'
                AND tanggal_pkb = '".$val['tanggal_pkb2']."'";
            //~
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }//*/

        $sql = "UPDATE service_data_pkb_full
            SET
            tanggal_selanjutnya='".$val['tanggal_pkb2']."',
            km_selanjutnya='".$val['km2']."'
            WHERE nomor_pkb = '".$val['nomor_pkb']."'
            AND noka = '".$val['noka2']."'
            AND tanggal_pkb = '".$val['tanggal_pkb1']."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();//*/

        /*$sql = "UPDATE service_data_pkb_full
            SET
            tanggal_sebelumnya=null,
            km_sebelumnya=null,
            tanggal_selanjutnya=null,
            km_selanjutnya=null
            WHERE nomor_pkb = '".$val['nomor_pkb']."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();//*/

        $i++;
    }
}
echo $i;
