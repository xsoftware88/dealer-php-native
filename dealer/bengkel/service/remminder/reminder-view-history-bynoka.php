<?php
include '../../../conf/conf.php';

session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    include '../../menu/reminder.php';
}
?>

<style>
    table {
        table-layout: fixed;
    }
</style>

<?php
// tampilkan all pkb by noka
if (isset($_GET['noka']) && $_GET['noka'] != "") {
    $sqlServiceVehicle = "SELECT *
        FROM `service_data_pkb_last`
        WHERE noka = '".$_GET['noka']."'";

    $stmt = $conn->prepare($sqlServiceVehicle);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dataServiceVehicle = $stmt->fetchAll();
        foreach ($dataServiceVehicle as $valServiceVehicle) {
?>
<div class="container-fluid">
<div class="row-fluid">
    <div class="span6">
        <br />
        <label>Nopol   </label> <?php echo $valServiceVehicle['nopol']; ?> <br />
        <label>Noka   </label>  <?php echo $valServiceVehicle['noka']; ?> <br />
        <br />
        <label>Nama / Telephone  </label>  <br />
        <?php echo $valServiceVehicle['nama']; ?> <br />
        <?php echo $valServiceVehicle['phone']; ?> <br />
    </div>
    <div class="span6">
<?php
if (isset($_GET['noka'])
&& !empty($_GET['noka'])){
//~ && isset($_GET['countid'])
//~ && !empty($_GET['countid'])) {
?>
<form class="form-horizontal" action='form-proses/reminder-proses-form.php' method="POST">
    <fieldset>
        <div id="legend">
            <legend class="">Proses Reminder</legend>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectRemminder">Hasil Reminder : &nbsp;</label>
            <div class="col-md-4">
                <select id="selectRemminder" name="selectRemminder" class="form-control">
                    <option value="">=======================</option>
                    <option value="Akurat Appointment">Akurat Appointment</option>
                    <option value="Akurat Belum Ada Waktu">Akurat Belum Ada Waktu</option>
                    <option value="Akurat Datang Sendiri">Akurat Datang Sendiri</option>
                    <option value="Reshedule Gak Diangkat">Reshedule Gak Diangkat</option>
                    <option value="Reshedule Tidak Aktif">Reshedule Tidak Aktif</option>
                    <option value="Reshedule Diluar Jangkauan">Reshedule Diluar Jangkauan</option>
                    <option value="Reshedule Diluar Jangkauan2">Reshedule Diluar Jangkauan2</option>
                    <option value="Invalid Dijual">Invalid Dijual</option>
                    <option value="Invalid Salah Sambung">Invalid Salah Sambung</option>
                    <option value="Early KM Belum Sampai">Early KM Belum Sampai</option>
                    <option value="Early Reminder Lain Waktu">Early Reminder Lain Waktu</option>
                    <option value="Lost Masuk Bengkel Lain">Lost Masuk Bengkel Lain</option>
                    <option value="Late Masuk Cabang Lain">Late Masuk Cabang Lain</option>
                    <option value="Late Masuk Bengkel Sendiri">Late Masuk Bengkel Sendiri</option>
                    <option value="sms">sms</option>
                </select>
          </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="keterangan">Observasi : &nbsp;</label>
            <div class="col-md-4">
                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="simpan"> </label>
            <div class="col-md-4">
                <?php
                    echo '<input type="hidden" id="noka" name="noka" value="'.$_GET['noka'].'">';
                    echo '<input type="hidden" id="countid" name="id" value="'.$_GET['id'].'">';
                    echo '<input type="hidden" id="nomorpkb" name="nomorpkb" value="'.$valServiceVehicle['nomor_pkb'].'">';
                ?>
                <input type="submit" id="simpan" name="simpan" class="btn" value="Simpan">
            </div>
        </div>
    </fieldset>
</form>
<?php
 }
?>
    </div>
    <div class="span12">
        <label>Reminder   </label>  <br />
        <?php
        $sqlReminderSa = "SELECT
            status_remminder,
            tanggal_remminder,
            sa,
            keterangan
            FROM `service_data_remminder`
            WHERE noka = '".$_GET['noka']."'
            ORDER BY `status_remminder` DESC";
//echo $sqlReminderSa;
//exit;
        $stmt = $conn->prepare($sqlReminderSa);
        $stmt->execute();
        $countReminderSa = $stmt->rowCount();

        if ($countReminderSa != 0) {
            $dataReminderSa = $stmt->fetchAll();
            echo $dataReminderSa[0]['status_remminder'] .' | ';
            echo $dataReminderSa[0]['tanggal_remminder'] .' | ';
            echo $dataReminderSa[0]['sa'] .' <br /> ';
            echo $dataReminderSa[0]['keterangan'];
        }
        ?>
        <br />
    </div>
</div>
</div>

<br />

<table class="table table-striped table-responsive">
    <thead>
        <tr>
            <th class='empat'>
                PKB / TANGGAL / KM
                <br />
                KELUHAN /
                DIAGNOSA
                <br />
                SARAN
            </th>
            <th class='empat'>
                JASA
            </th>
            <th class='empat'>
                PART <br /> QTY / DISC / HARGA
            </th>
            <th class='empat'>
                BAHAN
            </th>
        </tr>
    </thead>
    <tbody>
<?php
            $sqlServiceVehicleHistory = "SELECT *
                FROM  service_data_pkb_full
                WHERE noka = '".$_GET['noka']."'
                ORDER BY `tanggal_pkb` DESC";

            $stmt = $conn->prepare($sqlServiceVehicleHistory);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $dataServiceVehicleHistory = $stmt->fetchAll();
                foreach ($dataServiceVehicleHistory as $valServiceVehicleHistory) {
                    //var_dump($valServiceVehicleHistory);
?>
        <tr>
            <td class='empat'>
                <?php echo $valServiceVehicleHistory['nomor_pkb']; ?>
                <br />
                <?php echo $valServiceVehicleHistory['tanggal_pkb']; ?>
                <br />
                <?php echo $valServiceVehicleHistory['km']; ?>
                <br /> ======================= <br />
                <?php echo $valServiceVehicleHistory['keluhan']; ?>
                <br /> ======================= <br />
                <?php echo $valServiceVehicleHistory['diagnosa']; ?>
                <br /> ======================= <br />
                <?php echo $valServiceVehicleHistory['saran']; ?>
            </td>
            <td class='empat'>
            <?php
                 $sqlServiceVehicleHistoryJasa = "SELECT *
                    FROM `service_data_pkb_jasa`
                    WHERE nomor_pkb = '".$valServiceVehicleHistory['nomor_pkb']."'";
                $stmt = $conn->prepare($sqlServiceVehicleHistoryJasa);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $dataServiceVehicleHistoryJasa = $stmt->fetchAll();
                    foreach ($dataServiceVehicleHistoryJasa as $valServiceVehicleHistoryJasa) {
                        echo $valServiceVehicleHistoryJasa['order_jasa'];// . " <br /> ";
                        //echo $valServiceVehicleHistoryJasa['saran_jasa'] . " / ";
                        //echo $valServiceVehicleHistoryJasa['harga']
                        echo "<br />============<br />";
                    }
                }//*/
            ?>
            </td>
            <td class='empat'>
            <?php
                 $sqlServiceVehicleHistoryPart = "SELECT *
                    FROM `service_data_pkb_part`
                    WHERE nomor_pkb = '".$valServiceVehicleHistory['nomor_pkb']."'";

                $stmt = $conn->prepare($sqlServiceVehicleHistoryPart);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $dataServiceVehicleHistoryPart = $stmt->fetchAll();
                    foreach ($dataServiceVehicleHistoryPart as $valServiceVehicleHistoryPart) {
                        echo $valServiceVehicleHistoryPart['nama_part'] . " <br /> ";
                        echo $valServiceVehicleHistoryPart['qty'] . " / ";
                        echo $valServiceVehicleHistoryPart['diskon'] . " / ";
                        echo $valServiceVehicleHistoryPart['harga']
                        . "<br />============<br />";
                    }
                }//*/
            ?>
            </td>
            <td class='saran'>
            <?php
                $sqlServiceVehicleHistoryBahan = "SELECT *
                    FROM `service_data_pkb_bahan`
                    WHERE nomor_pkb = '".$valServiceVehicleHistory['nomor_pkb']."'";

                $stmt = $conn->prepare($sqlServiceVehicleHistoryBahan);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $dataServiceVehicleHistoryBahan = $stmt->fetchAll();
                    foreach ($dataServiceVehicleHistoryBahan as $valServiceVehicleHistoryBahan) {
                        echo $valServiceVehicleHistoryBahan['nama_bahan'] . " <br /> ";
                        echo $valServiceVehicleHistoryBahan['qty'] . " / ";
                        echo $valServiceVehicleHistoryBahan['diskon'] . " / ";
                        echo $valServiceVehicleHistoryBahan['harga']
                        . "<br />============<br />";
                    }
                }//*/
            ?>
            </td>
        </tr>
<?php
                }
            }
        }
?>
    </tbody>
</table>
<?php
    }
} else {
    echo "MAAF TIDAK ADA NOKA YANG DAPAT DI PROSES";
}
