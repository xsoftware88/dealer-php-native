<?php

include __DIR__ . '/../head.php';
include __DIR__ . '/../menu.php';

$user = $_SESSION['username'];
$cabang = $_SESSION['cabang'];

$statement = "SELECT *
    FROM sales_unit_kirim
    WHERE cabang='".$cabang."'
    AND month(tgl_simpan)=month(now())
    AND year(tgl_simpan)=year(now())
    ORDER BY jam_kirim ASC";

$stmt = $conn->prepare($statement);
$stmt->execute();
$dataRow = $stmt->rowCount();
?>

<style>
table {
        font-size: 12px;
        table-layout: fixed;
        word-wrap: break-word;
}
.jam{width:100px;}
.edit {width: 30px;}
.pdc {width: 100px;}
.driver {width: 100px;}
.spv {width: 60px;}
.telp{width: 100px;}
.kota{width: 70px;}
.noka{width: 140px;}
.spk{width: 100px;}
.bast{width: 50px;}
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
        <input type="text" id="search" class="input-medium search-query pull-right" name="search" placeholder="search di sini" />
        </div>
</form>

<?php
function showTable($dataRow, $stmt)
{
        ?>
        <table class="table table-bordered" id="result">
                <thead>
                <tr>
                        <th class="jam">Jam Pengiriman</th>
                        <th class="pdc">PDC</th>
                        <th class="driver">Driver</th>
                        <th class="spk">SPK</th>
                        <th class="kota">Kota</th>
                        <th class="spv">SPV</th>
                        <th class="noka">Noka</th>
                        <th class="tipe">Type/Warna</th>
                        <th class="variasi">Variasi</th>
                        <th class="edit"></th>
                </tr>
                </thead>

                <?php
                if($dataRow > 0) {
                $data = $stmt->fetchAll();

                foreach ($data as $val) {
                ?>

                <tbody>
                        <tr>

                        <?php
                        $time = strtotime($val['jam_kirim']);
                        $newTime = date('d-m-Y H:i', $time);

                if(!empty($val['jam_kirim'])) {
                        ?>

                        <td><?php echo $newTime; ?></td>
            <?php } else { ?>
            <td><?php echo $val['jam_kirim']; ?></td>
            <?php } ?>

                        <td>
                        <?php
// icon approval pdc
                        if ($val['approve_pdc'] == 1) { ?>
                                <input type="submit" class="btn btn-success" value="">
                         <?php echo $val['pdc'];
                        } else { ?>
                                <input type="submit" class="btn btn-danger" value="">
                        <?php } ?>
                        </td>
                        <td>
                        <?php
// icon approval driver
                        if ($val['approve_driver'] == 1) { ?>
                                <input type="submit" class="btn btn-success" value="">
                         <?php echo $val['driver'] ;
                        } else { ?>
                                <input type="submit" class="btn btn-danger" value="">
                        <?php } ?>
                        </td>
                        <td>
                        <a href="edit.php?id=<?php echo $val['id'];?>">

                        <?php echo $val['nomor_spk']; ?>
                        </a>
                        </td>
                        <td><?php echo $val['kota_cust']; ?></td>
                        <td><?php echo $val['spv']; ?></td>
                        <td><?php echo $val['noka']; ?></td>
                        <td><?php echo $val['type_unit']; ?><br><?php echo $val['warna_unit']; ?></td>
                        <td><?php echo strtoupper($val['variasi']); ?></td>
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
 } elseif (isset($_POST)) {
         if (!empty($_POST['mulai']) && !empty($_POST['sampai'])) {
// untuk search

                $mulai = $_POST['mulai'] . ' 00:00:00';
                $sampai = $_POST['sampai'] . ' 23:59:59';

                $searchStmt = "SELECT *
                                FROM sales_unit_kirim
                                WHERE cabang='".$cabang."'
                AND tgl_simpan < '".$sampai."'
                                AND tgl_simpan > '".$mulai."'
                                ORDER BY jam_kirim ASC";

                $search = $conn->prepare($searchStmt);
                $search->execute();

                showTable($dataRow, $search);
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

      $(document).ready(function(){
           $('#search').keyup(function(){
                search_table($(this).val());
           });
           function search_table(value){
                $('#result tr').each(function(){
                     var found = 'false';
                     $(this).each(function(){
                          if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                          {
                               found = 'true';
                          }
                     });
                     if(found == 'true')
                     {
                          $(this).show();
                     }
                     else
                     {
                          $(this).hide();
                     }
                });
           }
      });

</script>
