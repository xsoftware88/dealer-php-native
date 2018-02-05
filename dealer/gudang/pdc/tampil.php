<?php
session_start();

        include __DIR__ . "/head.php";

        if (!empty($_SESSION['username']))
        {
                $user = $_SESSION['username'];

        $today = date("Y-m-d");
                $awal  = date("Y-m-d", strtotime("-1 day"));
                $akhir = date("Y-m-d", strtotime("-2 day"));

                $statement = "SELECT *
                                FROM sales_unit_kirim
                                WHERE approve_pdc=0
                                AND hapus=0
                AND approve_driver=0
                AND jam_kirim >= '".$awal."'
                        AND jam_kirim <= '".$akhir."'
                                ORDER BY jam_kirim ASC";

                $stmt = $conn->prepare($statement);
                $stmt->execute();
        } else {
                echo "<script type='text/javascript'>
                    window.location = '".homeUrl."user/login/form/login.php';
                </script>";
        }
?>

<style>
        table {
                font-size: 12px;
                table-layout: fixed;
                word-wrap: break-word;
        }
        .pdc {width: 60px;}
        .driver {width: 60px;}
        .spv {width: 60px;}
        .telp{width: 100px;}
</style>

<div class="container-fluid">
        <form id="formCari" class="form-inline" action="" method="POST">
    <!-- Select Basic -->
    <div class="control-group">
            <label class="control-label" for="tanggal">Mulai dari :</label>
            <input type="text" class="dtpick" id="tanggal" name="mulai">
            <label class="control-label" for="tanggal">Sampai :</label>
            <input type="text" class="dtpick" id="tanggal" name="sampai">
            <input type="submit" class="btn btn-primary" name ="cariData" value="Cari">
        </div>
</form>

<?php
if (!$_POST) {
        // tanpa search
?>

        <table class="table table-bordered">
                <thead>
                <tr>
                        <th class="jam">Tanggal AFI</th>
                        <th class="jam">Rencana Kirim</th>
                        <th class="noka">Noka/Nosin</th>
                        <th class="tipe">Type/Warna</th>
                <th class="gesekan">Gesekan</th>
                        <th class="variasi">Variasi</th>
        <?php if ($user == 'NIKO') { ?>
                <th>Detail</th>
        <?php } ?>
                </tr>
                </thead>

                <?php
                if($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();

                foreach ($data as $val) {
                ?>

                <tbody>
                        <tr>

                        <?php
                        $time = strtotime($val['jam_kirim']);
                        $newTime = date('d-m-Y H:i', $time);
                        ?>
                        <td><?php echo $val['tgl_simpan']; ?></td>
                        <td><?php echo $newTime; ?></td>
                        <td>
                        <a href="edit.php?id=<?php echo $val['id']; ?>">
                        <?php echo $val['noka'] ."/". $val['nosin']; ?>
                        </a>
                        </td>
                        <td><?php echo $val['type_unit']; ?><br><?php echo $val['warna_unit']; ?></td>
            <td><?php echo $val['gesekan']; ?></td>
                        <td><?php echo $val['variasi']; ?></td>
            <?php if ($user == 'NIKO') { ?>
            <td>
                <a href="<?php echo homeUrl; ?>dealer/sales/data/cetak-pdf-bast.php?kode=<?php echo $val['nomor_spk']; ?>">Cetak BAST</a>
                <br>
                <a href="<?php echo homeUrl; ?>dealer/gudang/detail-unit.php?kode=<?php echo $val['id']; ?>">Detail Customer</a>
            </td>
        <?php } ?>
                </tr>
                </tbody>
<?php
                }
        }
?>
        </table>


        <?php } elseif (isset($_POST)) {
          if (!empty($_POST['mulai']) && !empty($_POST['sampai'])) {
// untuk search

                $mulai = $_POST['mulai'] . ' 00:00:00';
                $sampai = $_POST['sampai'] . ' 23:59:59';

                $searchStmt = "SELECT *
                                FROM sales_unit_kirim
                                WHERE jam_kirim < '".$sampai."'
                                AND jam_kirim > '".$mulai."'
                                ORDER BY jam_kirim ASC";

                $search = $conn->prepare($searchStmt);
                $search->execute();
                ?>

                <table class="table table-bordered">
                <thead>
                <tr>
                        <th class="jam">Tanggal AFI</th>
                        <th class="jam">Rencana Kirim</th>
                        <th class="noka">Noka/Nosin</th>
                        <th class="tipe">Type/Warna</th>
                <th class="gesekan">Gesekan</th>
                        <th class="variasi">Variasi</th>
                <?php if ($user == 'NIKO') { ?>
                <th>Detail</th>
                <?php } ?>
                </tr>
                </thead>

                <?php
                if($search->rowCount() > 0) {
                $data = $search->fetchAll();

                foreach ($data as $val) {
                ?>

                <tbody>
                        <tr>

                        <?php
                        $time = strtotime($val['jam_kirim']);
                        $newTime = date('d-m-Y H:i', $time);
                        ?>

                        <td><?php echo $val['tgl_simpan']; ?></td>
                        <td><?php echo $newTime; ?></td>
                        <td>
                        <a href="edit.php?id=<?php echo $val['id']; ?>">
                        <?php echo $val['noka'] ."/". $val['nosin']; ?>
                        </a>
                        </td>

                        <td><?php echo $val['type_unit']; ?><br><?php echo $val['warna_unit']; ?></td>
            <td><?php echo $val['gesekan']; ?></td>
                        <td><?php echo $val['variasi']; ?></td>
            <?php if ($user == 'NIKO') { ?>
            <td>
                <a href="<?php echo homeUrl; ?>dealer/sales/data/cetak-pdf-bast.php?kode=<?php echo $val['nomor_spk']; ?>">Cetak BAST</a>
                <br>
                <a href="<?php echo homeUrl; ?>dealer/gudang/detail-unit.php?kode=<?php echo $val['id']; ?>">Detail Customer</a>
            </td>
        <?php } ?>
                </tr>
                </tbody>
<?php
                }
        }
?>
        </table>

        <?php
}
}
        ?>

</div>
<script type="text/javascript">
    $(function(){
        $(".dtpicker").appendDtpicker({
            "closeOnSelected": true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
    $(function(){
        $(".dtpick").appendDtpicker({
            "closeOnSelected": true,
            "dateOnly" : true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
</script>
