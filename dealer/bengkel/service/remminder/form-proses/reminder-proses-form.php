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
            FROM `service_data_remminder`
            WHERE noka = '".$_POST['noka']."'";

        $stmt = $conn->prepare($sqlRwc);
        $stmt->execute();
        $rowRwc  = $stmt->rowCount();

        if ($rowRwc != 0) {
            $dataRwc = $stmt->fetchAll();
            // update data remminder
            $sql = "UPDATE service_data_remminder
                SET
                sa = '".$sa."',
                tipe_data = '-',
                nomor_pkb = '".$_POST['nomorpkb']."',
                status_remminder = '".$_POST['selectRemminder']."',
                keterangan = '".$_POST['keterangan']."',
                tanggal_remminder = now()
                WHERE noka = '".$_POST['noka']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else {
            // new data remminder
            $sql = "INSERT INTO service_data_remminder
                (noka,
                nomor_pkb,
                sa,
                tipe_data,
                status_remminder,
                keterangan,
                tanggal_remminder)
                VALUES (
                '".$_POST['noka']."',
                '".$_POST['nomorpkb']."',
                '".$sa."',
                '-',
                '".$_POST['selectRemminder']."',
                '".$_POST['keterangan']."',
                now())";

            //~ var_dump($sql);exit;

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            //$idSrs = $conn->lastInsertId();
        }

        // include kpi
        include 'reminder-proses-kpi.php';

        // cek appoitmen
        if ($_POST['selectRemminder'] == "Akurat Appointment") {
            ?>
            <!--form id="kirimDataSebelumya" action="reminder-appoitment-form.php" method="post">
                <?php
                    /*echo '<input type="hidden" name="noka" value="'.$_POST['noka'].'">';
                    echo '<input type="hidden" name="countid" value="'.$_POST['countid'].'">';
                    echo '<input type="hidden" name="selectRemminder" value="'.$_POST['selectRemminder'].'">';
                    echo '<input type="hidden" name="keterangan" value="'.$_POST['keterangan'].'">';*/
                ?>
            </form>
            <script type="text/javascript">
                //document.getElementById('kirimDataSebelumya').submit();
            </script-->
            <?php
            include 'reminder-proses-appoitment.php';
            ?>
            <script type="text/javascript">
                //window.location = "https://www.appsheet.com/start/fac16400-fdcc-4226-9fe0-dd6a40ed2cd8";
                window.location = "https://www.appsheet.com/start/fac16400-fdcc-4226-9fe0-dd6a40ed2cd8#appName=APOINTMENTVSPHP-238278&control=APP&group=%5B%5D&page=fastTable&sort=%5B%7B%22Column%22%3A%22TODAY%22%2C%22Order%22%3A%22Ascending%22%7D%5D&table=APP";
            </script>
            <?php
        }

        if (isset($_POST['sbi'])) {
            ?>
                <script type="text/javascript">
                    window.location = "../reminder-sbi.php?noka=<?php echo $_POST['noka']; ?>&id=<?php echo $_POST['id']; ?>";
                </script>
            <?php
        } else {
        ?>
            <script type="text/javascript">
                window.location = "../reminder-view-history-bynoka.php?noka=<?php echo $_POST['noka']; ?>&id=<?php echo $_POST['id']; ?>";
            </script>
        <?php
        }
    } else {
        echo "Belum pilih Hail Remminder <br />";
        echo "<a href='../reminder-view-history-bynoka.php?noka=".$_POST['noka']."&id=".$_POST['id']."'>Klik Untuk Kembali</a>";
    }
}
