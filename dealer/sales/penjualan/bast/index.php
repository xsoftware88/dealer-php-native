<?php

    include __DIR__ . '/../../head.php';

    $user = $_SESSION['username'];
    $modul = $_SESSION['modul'];

    if (!empty($user) && ($modul == 'sales')) {
        
        $statement = "SELECT * 
                FROM sales_unit_kirim 
                WHERE spv = '".$user."'
                AND hapus=0
                AND approve_driver=0
                ORDER BY jam_kirim DESC";

        $stmt = $conn->prepare($statement);
        $stmt->execute();
        $dataRow = $stmt->rowCount();

        include __DIR__ . '/../../menu.php';
        
    } else {
        echo "<script type='text/javascript'>
            window.location = 'http://".$_SERVER['HTTP_HOST']."/dealer/user/login/form/login.php?p=".$_GET['p']."'
        </script>";
    }
?>

<style>
    .table {
        font-size: 12px;
        table-layout: fixed;
        word-wrap: break-word;
    }
    .edit {width: 30px;}
    .pdc {width: 60px;}
    .driver {width: 60px;}
    .spv {width: 60px;}
    .telp{width: 100px;}
    .kota{width: 80px;}
    .spk{width:90px;}
    .jam{width: 120px;}
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
function showTable($dataRow, $stmt)
{
?>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th class="jam">Jam Pengiriman</th>
            <th class="pdc">PDC</th>
            <th class="driver">Driver</th>
            <th class="spk">SPK</th>
            <th class="kota">Kota</th>
            <th class="telp">No.Telp</th>
            <th class="spv">BAST</th>
            <th class="noka">Noka</th>
            <th class="tipe">Type/Warna</th>
            <th class="variasi">Keterangan</th>
            <th class="edit"></th>
        </tr>
        </thead>
        
        <?php 
        if ($dataRow > 0) {
            $data = $stmt->fetchAll();
        ?>
        
        <tbody>
            <?php foreach ($data as $val) { ?>
            <tr>
            
            <?php
                $time = strtotime($val['jam_kirim']);
                $newTime = date('d-m-Y H:i', $time);
        
            if (!empty($val['jam_kirim'])) {
            ?>
                <td><?php echo $newTime; ?></td>
            <?php
            } else { ?>
                <td></td>
            <?php
            }
            ?>
            <td><?php echo $val['pdc']; ?></td>
            <td><?php echo $val['driver']; ?></td>
        
            <?php
            // user yg input bisa edit
            if (isset($_SESSION['username']) && $val['spv'] == $_SESSION['username']) { 
            ?>
            <td>
            <a href="edit.php?id=<?php echo $val['id'];?>">
            <?php echo $val['nomor_spk']; ?>
            </a>
            </td>

            <?php
            } else { 
            ?>
            <td><?php echo $val['nomor_spk']; ?></td>
            <?php } ?>

            <td><?php echo $val['kota_cust']; ?></td>
            <td><?php echo $val['nomor_telp']; ?></td>

            <?php
            if (isset($_SESSION['username']) && ($val['spv'] == $_SESSION['username'])) {
                if(!empty($val['nomor_bast'])) { ?>
            <td><a target="_blank" href="<?php echo $val['nomor_bast']; ?>">BAST</a></td>
            <?php } else { ?>
            <td>BAST</td>
            <?php } 
            }
            ?>
            
            <td><?php echo $val['noka']; ?></td>
            <td><?php echo $val['type_unit']; ?>
            <br>
            <?php echo $val['warna_unit']; ?>
            </td>
            <td><?php echo $val['keterangan']; ?></td>
            <td>
            <?php 
// icon approval
            if  ($val['approve_adm'] == 1) {
                echo "<i class='icon-ok'></i>";
            } else {
                echo "<i class='icon-remove'></i>";
            } 
            ?>
            </td>
        </tr>
        </tbody>
<?php
        }
    }
?>
    </table>
<?php
}

if (!$_POST) {
    // tanpa search
    showTable($dataRow, $stmt);
}
else if (isset($_POST))
{
    $mulai = $_POST['mulai'] . ' 00:00:00';
    $sampai = $_POST['sampai'] . ' 23:59:59';

    $searchStmt = "SELECT * 
                FROM sales_unit_kirim 
                WHERE  spv = '".$user."' 
                AND tgl_simpan < '".$sampai."' 
                AND tgl_simpan > '".$mulai."' 
                ORDER BY jam_kirim ASC";
    $stmt = $conn->prepare($searchStmt);
    $stmt->execute();

    showTable($dataRow, $stmt);
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
