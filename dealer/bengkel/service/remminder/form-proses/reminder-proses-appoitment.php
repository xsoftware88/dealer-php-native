<?php

echo "//ke form Akurat Appointment";

$sqlAppoitment = "SELECT id
    FROM `service_data_appoitment`
    WHERE noka = '".$_POST['noka']."'
    AND sa = '".$sa."'";

$stmt = $conn->prepare($sqlAppoitment);
$stmt->execute();
$countAppoitment = $stmt->rowCount();
$dataAppoitment = $stmt->fetchAll();

if ($countAppoitment != 0) {
    try {
        $sqlUpdateAppoitment = "UPDATE service_data_appoitment
            SET
            sa = '".$sa."',
            user_update = '".$sa."',
            tanggal_update = now()
            WHERE id = '".$dataAppoitment[0]['id']."'";
            //var_dump($sqlAppoitment);exit;

        $stmt = $conn->prepare($sqlUpdateAppoitment);
        $stmt->execute();

        $idAppoitment = $dataAppoitment[0]['id'];
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        break;
    }
} else {
    try {
        $sqlAppoitment = "INSERT INTO service_data_appoitment
            (noka,
            sa,
            user_update,
            tanggal_update,
            user_input,
            tanggal_simpan)
            VALUES (
            '".$_POST['noka']."',
            '".$sa."',
            '".$sa."',
            now(),
            '".$sa."',
            now())";
            //var_dump($sqlAppoitment);exit;
        $conn->exec($sqlAppoitment);

        $idAppoitment = $conn->lastInsertId();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        break;
    }
}
