<?php
include '../../../../conf/conf.php';

// echo'<pre>';
if (isset($_POST['nopol']) && !empty($_POST['nopol'])) {
    $now = new DateTime();
    $now = $now->format('Y-m-d');

    $sql  = "SELECT *
        FROM service_data_appoitment
        WHERE nopol = '".$_POST['nopol']."'";
        //AND DATE(janji_kedatangan) = '".$now."'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rowData  = $stmt->rowCount();

    if ($rowData == 0) {
        // echo 'new data';
        try {
            $sqlAppoitment = "INSERT INTO service_data_papan_kontrol
                (nopol,
                user_update,
                tanggal_update,
                user_input,
                tanggal_simpan)
                VALUES (
                '".$_POST['nopol']."',
                'SATPAM',
                'SATPAM',
                now())";
                //var_dump($sqlAppoitment);exit;
            $conn->exec($sqlAppoitment);

            $idAppoitment = $conn->lastInsertId();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    } else {
        $data = $stmt->fetchAll();
        // echo 'data ada';
        //~ var_dump($data[0]['janji_kedatangan']);

        $janjiDatang = strtotime($data[0]['janji_kedatangan']);
        $janjiDatang = date('Y-m-d', $janjiDatang);

        $sql  = "SELECT *
            FROM service_data_papan_kontrol
            WHERE nopol = '".$_POST['nopol']."'
            AND DATE(janji_kedatangan) = '".$janjiDatang."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rowData  = $stmt->rowCount();

        if ($rowData == 0) {
            // echo 'new data';
            try {
                $sqlAppoitment = "INSERT INTO service_data_papan_kontrol
                    (nopol,
                    user_update,
                    tanggal_update,
                    user_input,
                    tanggal_simpan)
                    VALUES (
                    '".$_POST['nopol']."',
                    'SATPAM',
                    now(),
                    'SATPAM',
                    now())";
                    //var_dump($sqlAppoitment);exit;
                $conn->exec($sqlAppoitment);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        } else {
            // echo 'data ada';
            try {
                $sqlUpdateAppoitment = "UPDATE service_data_papan_kontrol
                    SET
                    user_update = 'SATPAM',
                    tanggal_update = now()
                    WHERE nopol = '".$_POST['nopol']."'";
                    //var_dump($sqlAppoitment);exit;

                $stmt = $conn->prepare($sqlUpdateAppoitment);
                $stmt->execute();
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }
    echo 'Data Telah Masuk <br />
    <a href="/dealer/bengkel/service/layanan-pkb/form/antrian-service.php">Kembali Ke Form Input Nopol</a>';
}
