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
        FROM `service_data_sbi`
        WHERE noka = '".$_GET['noka']."'";

    $stmt = $conn->prepare($sqlServiceVehicle);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $dataServiceVehicle = $stmt->fetchAll();
        foreach ($dataServiceVehicle as $valServiceVehicle) {
?>
<div class="container-fluid">
<div class="row-fluid">
    <div class="span12">
        <br />
        <label>Noka   </label>  <?php echo $valServiceVehicle['noka']; ?> <br />
        <br />
        <label>Nama / Alamat / Telephone  </label>  <br />
        <?php echo $valServiceVehicle['nama']; ?> <br />
        <?php echo $valServiceVehicle['alamat']; ?> <br />
        <?php echo $valServiceVehicle['phone']; ?> <br />
    </div>
    <div class="span12">
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
                            echo '<input type="hidden" id="sbi" name="sbi" value="sbi">';
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
</div>
</div>
<?php
    }
} else {
    echo "MAAF TIDAK ADA NOKA YANG DAPAT DI PROSES";
}
