<?php

echo "<pre>";
// janji kledatangan

if (isset($_POST['datang']) && !empty($_POST['datang'])) {
    $sql  = "SELECT *
        FROM service_data_papan_kontrol
        WHERE noka = '".$_POST['noka']."'";
        //AND DATE(janji_kedatangan) = '".$now."'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rowData  = $stmt->rowCount();


}
