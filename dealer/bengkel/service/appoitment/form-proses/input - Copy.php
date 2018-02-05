<?php
include '../../../../conf/conf.php';
session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "/dealer/bengkel/login/login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    //include '../../../menu/reminder.php';
}
echo "<pre>";
// janji kledatangan
$startTime  = $_POST['datang'];
//+ 1 hour to time
$rangeAwal  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($startTime)));
//- 1 hour to time
$rangeAkhir = date('Y-m-d H:i:s',strtotime('-1 hour',strtotime($startTime)));

// target peneriman an SA paling lama
$targetSa   = date('Y-m-d H:i:s',strtotime('+15 minute',strtotime($startTime)));
$targetPkb  = date('Y-m-d H:i:s',strtotime('-15 minute',strtotime($_POST['penyerahan'])));

if (isset($_POST['tipeOrder'])) {
    if ($_POST['tipeOrder'] == 'sbi') {
        // target peneriman an Forman paling lama
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));
        // target peneriman an Tenisi paling lama
        $targetTeknisi = '+15 minute';
        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$targetTeknisi.' minute',$targetForman));
    } else if ($_POST['tipeOrder'] == 'sbe 10k'
    || $_POST['tipeOrder'] == 'sbe 30k'
    || $_POST['tipeOrder'] == 'sbe 50k') {
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));

        $targetTeknisi = '+70 minute';
        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$targetTeknisi.' minute',$targetForman));
    } else if ($_POST['tipeOrder'] == 'sbe 20k'
    || $_POST['tipeOrder'] == 'sbe 40k'
    || $_POST['tipeOrder'] == 'sbe other') {
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));

        $targetTeknisi = '+85 minute';
        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$targetTeknisi.' minute',$targetForman));
    } else if ($_POST['tipeOrder'] == 'twc'
    || $_POST['tipeOrder'] == 'engine tuneup'
    || $_POST['tipeOrder'] == 'return') {
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));

        $targetTeknisi = '+55 minute';
        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$targetTeknisi.' minute',$targetForman));
    } else if ($_POST['tipeOrder'] == 'grr ringan') {
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));

        $targetTeknisi = '+10 minute';
        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$targetTeknisi.' minute',$targetForman));
    } else if ($_POST['tipeOrder'] == 'grr berat') {
        $targetForman  = '+5 minute';
        $targetForman = date('Y-m-d H:i:s',strtotime('+'.$targetForman.' minute',$targetSa));

        // janji datang +15 menit, s/d janji penyerahan -15 menit
        $awal  = strtotime($targetForman);
        $akhir = strtotime($targetPkb);

        $interval = abs($akhir - $awal);
        $minutes  = round($interval / 60);
        $minutes  = $minutes - 5;

        $targetTeknisi = date('Y-m-d H:i:s',strtotime('+'.$minutes.' minute',$awal));
        //$targetForman = '30 minute';
    }
}

if (!isset($_POST['pkb'])) {
    echo 'data non remminder';
    var_dump($_POST);
    // cek stall +- 1 jam kosong atau tidak

    $sql  = "SELECT *
        FROM service_data_appoitment
        WHERE noka = '".$_POST['noka']."'";
        //AND DATE(janji_kedatangan) = '".$now."'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rowData  = $stmt->rowCount();

    if ($rowData == 0) {
        echo 'data baru';
        try {
            $sqlAppoitment = "INSERT INTO service_data_appoitment
                (nomor_pkb,
                nopol,
                noka,
                pembawa,
                tlp_pembawa,
                keluhan,
                tipe_order,
                stall,
                opl,
                service_plus,
                sa,
                janji_kedatangan,
                janji_penyerahan,
                user_update,
                tanggal_update,
                user_input,
                tanggal_simpan)
                VALUES (
                '-',
                '".$_POST['nopol']."',
                '".$_POST['noka']."',
                '".$_POST['pembawa']."',
                '".$_POST['tlpPembawa']."',
                '".$_POST['keluhan']."',
                '".$_POST['tipeOrder']."',
                '".$_POST['stall']."',
                '".$_POST['opl']."',
                '".$_POST['servicePlus']."',
                '".$sa."',
                '".$_POST['datang']."',
                '".$_POST['penyerahan']."',
                '".$sa."',
                now(),
                '".$sa."',
                now())";
                //var_dump($sqlAppoitment);exit;
            $conn->exec($sqlAppoitment);
            //$idAppoitment = $conn->lastInsertId();

            $sqlAppoitment = "INSERT INTO service_data_papan_kontrol
                (pkb_remminder,
                nomor_pkb,
                nopol,
                noka,
                keluhan,
                tipe_order,
                stall,
                opl,
                service_plus,
                sa,
                target_sa,
                target_forman,
                target_teknisi,
                janji_kedatangan,
                janji_penyerahan,
                user_update,
                tanggal_update,
                user_input,
                tanggal_simpan)
                VALUES (
                '-',
                '-',
                '".$_POST['nopol']."',
                '".$_POST['noka']."',
                '".$_POST['pembawa']."',
                '".$_POST['tlpPembawa']."',
                '".$_POST['keluhan']."',
                '".$_POST['tipeOrder']."',
                '".$_POST['stall']."',
                '".$_POST['opl']."',
                '".$_POST['servicePlus']."',
                '".$sa."',
                '".$_POST['datang']."',
                '".$_POST['penyerahan']."',
                '".$sa."',
                now(),
                '".$sa."',
                now())";
                //var_dump($sqlAppoitment);exit;
            $conn->exec($sqlAppoitment);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    } else {
        echo 'data update';
        try {
            $sqlUpdateAppoitment = "UPDATE service_data_appoitment
                SET
                nomor_pkb = '-',
                nopol = '".$_POST['nopol']."',
                noka = '".$_POST['noka']."',
                pembawa = '".$_POST['pembawa']."',
                tlp_pembawa = '".$_POST['tlpPembawa']."',
                keluhan= '".$_POST['keluhan']."',
                tipe_order = '".$_POST['tipeOrder']."',
                stall = '".$_POST['stall']."',
                opl = '".$_POST['opl']."',
                service_plus = '".$_POST['servicePlus']."',
                sa = '".$sa."',
                janji_kedatangan = '".$_POST['datang']."',
                janji_penyerahan = '".$_POST['penyerahan']."',
                user_update = '".$sa."',
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
} else {
    echo 'data dari remminder';
    $sql  = "SELECT *
        FROM service_data_appoitment
        WHERE noka = '".$_POST['noka']."'";
        //AND DATE(janji_kedatangan) = '".$now."'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rowData  = $stmt->rowCount();

    if ($rowData == 0) {
        echo 'data baru';
        try {
            $sqlAppoitment = "INSERT INTO service_data_appoitment
                (nomor_pkb,
                nopol,
                noka,
                pembawa,
                tlp_pembawa,
                keluhan,
                tipe_order,
                stall,
                opl,
                service_plus,
                sa,
                janji_kedatangan,
                janji_penyerahan,
                user_update,
                tanggal_update,
                user_input,
                tanggal_simpan)
                VALUES (
                '".$_POST['pkb']."',
                '".$_POST['nopol']."',
                '".$_POST['noka']."',
                '".$_POST['pembawa']."',
                '".$_POST['tlpPembawa']."',
                '".$_POST['keluhan']."',
                '".$_POST['tipeOrder']."',
                '".$_POST['stall']."',
                '".$_POST['opl']."',
                '".$_POST['servicePlus']."',
                '".$sa."',
                '".$_POST['datang']."',
                '".$_POST['penyerahan']."',
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
    } else {
        echo 'data update';
        try {
            $sqlUpdateAppoitment = "UPDATE service_data_appoitment
                SET
                nomor_pkb = '".$_POST['pkb']."',
                nopol = '".$_POST['nopol']."',
                noka = '".$_POST['noka']."',
                pembawa = '".$_POST['pembawa']."',
                tlp_pembawa = '".$_POST['tlpPembawa']."',
                keluhan= '".$_POST['keluhan']."',
                tipe_order = '".$_POST['tipeOrder']."',
                stall = '".$_POST['stall']."',
                opl = '".$_POST['opl']."',
                service_plus = '".$_POST['servicePlus']."',
                sa = '".$sa."',
                janji_kedatangan = '".$_POST['datang']."',
                janji_penyerahan = '".$_POST['penyerahan']."',
                user_update = '".$sa."',
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
