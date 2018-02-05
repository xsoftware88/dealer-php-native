<?php
ini_set('MAX_EXECUTION_TIME', -1);
include '../../../conf/conf.php';

echo "<pre>";
$i             = 0;
$sqlPkb = "SELECT id, noka, sa
    FROM `service_data_pkb_last`";

$stmt = $conn->prepare($sqlPkb);
$stmt->execute();
$rowPkb = $stmt->rowCount();

if ($rowPkb != 0) {
    $dataPkb = $stmt->fetchAll();

    foreach ($dataPkb as $val) {
        $datavehicle = $stmt->fetchAll();
        try {
            $sql = "UPDATE service_data_remminder
            SET
            sa = '".$val['sa']."'
            WHERE noka = '".$val['noka']."'";
            $conn->exec($sql);

            echo $val['id'] .'<br />';
            $i++;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
}

echo $i;
