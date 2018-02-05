<?php
include '../../../../conf/conf.php';

session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
}

echo "<pre>";
if (!empty($_POST)) {

    if (isset($_POST['selectRemminder'])
    && !empty($_POST['selectRemminder'])
    && isset($_POST['noka'])
    && !empty($_POST['noka'])
    && isset($_POST['simpan'])
    && $_POST['simpan'] == "Simpan") {

        $sqlRwc = "SELECT *
            FROM `view_remminder_with_count`
            WHERE noka = '".$_POST['noka']."'";

        $stmt = $conn->prepare($sqlRwc);
        $stmt->execute();
        $rowRwc  = $stmt->rowCount();

        if ($rowRwc != 0) {
            $dataRwc = $stmt->fetchAll();
            // data ada
            $sqlDataPhone = "SELECT id,phone
                FROM `service_cust_phone`
                WHERE service_vehicle = '".$dataRwc[0]['idVehicle']."'
                ORDER BY id DESC LIMIT 1";

            $stmt = $conn->prepare($sqlDataPhone);
            $stmt->execute();
            $countDataPhone = $stmt->rowCount();

            if ($countDataPhone != 0) {
                $dataDataPhone = $stmt->fetchAll();
            } else if ($countDataPhone == 0) {
                $dataDataPhone[0]['id'] = null;
            }

            if (!is_null($dataRwc[0]['idCount'])) {
                // cek reminder sa by noka dan idcount
                $sqlSrs = "SELECT *
                    FROM `service_remminder_sa`
                    WHERE service_remminder_count = '".$dataRwc[0]['idCount']."'
                    AND noka = '".$_POST['noka']."'";

                $stmt = $conn->prepare($sqlSrs);
                $stmt->execute();
                $rowSrs  = $stmt->rowCount();
                $dataSrs = $stmt->fetchAll();

                if ($rowSrs == 0) {
                    echo 'insert new service_remminder_sa';
                    try {
                        $sql = "INSERT INTO service_remminder_sa
                            (service_remminder_count,
                            service_vehicle,
                            service_cust_phone,
                            noka,
                            sa,
                            tipe_data,
                            status_remminder,
                            keterangan,
                            tanggal_remminder)
                            VALUES (
                            '".$dataRwc[0]['idCount']."',
                            '".$dataRwc[0]['idVehicle']."',
                            '".$dataDataPhone[0]['id']."',
                            '".$_POST['noka']."',
                            '".$sa."',
                            '-',
                            '".$_POST['selectRemminder']."',
                            '".$_POST['keterangan']."',
                            now())";

                        //~ var_dump($sql);exit;

                        $conn->exec($sql);
                        $idSrs = $conn->lastInsertId();
                    }
                    catch (PDOException $e) {
                        echo $e->getMessage();
                        break;
                    }
                    // include kpi
                    include 'reminder-proses-kpi.php';
                } else {
                    echo 'update service_remminder_sa 2';
                    try {
                        $sqlUpdateVehicle = "UPDATE service_remminder_sa
                            SET
                            service_vehicle = '".$dataRwc[0]['idVehicle']."',
                            service_cust_phone = '".$dataDataPhone[0]['id']."',
                            noka = '".$_POST['noka']."',
                            sa = '".$sa."',
                            tipe_data = '-',
                            status_remminder = '".$_POST['selectRemminder']."',
                            keterangan = '".$_POST['keterangan']."',
                            tanggal_remminder = now()
                            WHERE service_vehicle = '".$dataRwc[0]['idVehicle']."'
                            AND noka = '".$_POST['noka']."'";

                        //~ var_dump($sqlUpdateVehicle);exit;

                        $stmt = $conn->prepare($sqlUpdateVehicle);
                        $stmt->execute();

                        $idSrs = $dataSrs[0]['id'];
                        $idSrc = $dataRwc[0]['idCount'];
                    }
                    catch (PDOException $e) {
                        echo $e->getMessage();
                        break;
                    }
                    // sebelum include kpi, badingkan data
                    // bandingkan $_POST['selectRemminder'] dengan yg sebelumnya
                    //~ if ($_POST['selectRemminder'] == $dataSrs[0]['status_remminder']) {
                    //~ }
                    $seninAwal  = date("Y-m-d",strtotime('monday this week'));
                    $seninAwal1 =  $seninAwal.' 00:00:00';

                    if ($dataSrs[0]['tanggal_remminder'] < $seninAwal1) {
                        // jika periode < dari awal langsung include
                        include 'reminder-proses-kpi.php';
                    }
                    //~ else if ($dataSrs[0]['tanggal_remminder'] >= $seninAwal1) {
                        //~ // bandingkan tanggal_remminder apa pada periode yang sama
                        //~ // jika di periode sama dan $_POST['selectRemminder'] tapi jadi appointment maka include
                        //~ //if ($_POST['selectRemminder'] == '') {
                        //~ //    include 'reminder-proses-kpi.php';
                        //~ //}
                    //~ }

            ?>
            <script type="text/javascript">
                window.location = "../reminder-view-history-bynoka.php?noka=<?php echo $_POST['noka']; ?>&countid=<?php echo $idSrc; ?>";
            </script>
            <?php

                }
            } else {
                echo 'insert new count dan reminder sa';
                try {
                    $sql = "INSERT INTO service_remminder_count(
                        service_vehicle,
                        service_vehicle_history,
                        noka,
                        km_terakhir,
                        km_rata_rata,
                        tanggal_service_terakhir,
                        tanggal_next_service)
                    VALUES (
                    '".$dataRwc[0]['idVehicle']."',
                    '".$dataRwc[0]['idHistory']."',
                    '".$dataRwc[0]['km_sebelumnya']."',
                    '".$_POST['noka']."',
                    '0',
                    '".$dataRwc[0]['tanggal_service']."',
                    now())";

                    //~ var_dump($sql);exit;

                    $conn->exec($sql);
                    $idSrc = $conn->lastInsertId();

                    $sql = "INSERT INTO service_remminder_sa
                        (service_remminder_count,
                        service_vehicle,
                        service_cust_phone,
                        noka,
                        sa,
                        tipe_data,
                        status_remminder,
                        keterangan,
                        tanggal_remminder)
                        VALUES (
                        '".$idSrc."',
                        '".$dataRwc[0]['idVehicle']."',
                        '".$dataDataPhone[0]['id']."',
                        '".$_POST['noka']."',
                        '".$sa."',
                        '-',
                        '".$_POST['selectRemminder']."',
                        '".$_POST['keterangan']."',
                        now())";

                    //~ var_dump($sql);exit;

                    $conn->exec($sql);
                    $idSrs = $conn->lastInsertId();
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                    break;
                }

                // include kpi
                include 'reminder-proses-kpi.php';
            }

            // include appoitment
            include 'reminder-proses-appoitment.php';

            ?>
            <script type="text/javascript">
                window.location = "../reminder-view-history-bynoka.php?noka=<?php echo $_POST['noka']; ?>&countid=<?php echo $idSrc; ?>";
            </script>
            <?php

        } else {
            // data tidak valid noka tidak ada
            // kembalikan ke asal
            ?>
            <script type="text/javascript">
                window.location = "../reminder-list.php";
            </script>
            <?php
        }
    } else {
        //kembalikan ke asal
        ?>
        <script type="text/javascript">
            window.location = "../reminder-list.php";
        </script>
        <?php
    }
}
