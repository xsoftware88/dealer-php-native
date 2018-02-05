<?php

include __DIR__ . '/../../head.php';

    $user = $_SESSION['username'];
    $modul = $_SESSION['modul'];
    //~ $modul = $_GET['p'];

        if(empty($_SESSION['username'])) {
            echo "<script type='text/javascript'>
                window.location = '".homeUrl."dealer/user/login/form/login.php?p=".$_GET['p']."'
            </script>";
        } else {
            $user = $_SESSION['username'];

            include __DIR__ . '/../../menu.php';
        }

        $statement="SELECT DISTINCT id,nama FROM master_karyawan
                WHERE user_input='".$user."'
                AND active=1
        ORDER BY nama ASC";
        $stmt = $conn->prepare($statement);
        $stmt->execute();
        $data = $stmt->fetchAll();
?>
<style>
        .table {
                width:40%;
                font-size: 13px;
                table-layout: fixed;
                word-wrap: break-word;
        }
</style>
        <div class="container-fluid">
        <form id="formCari" class="form-inline" action="" method="POST" name="cari">
    <!-- Select Basic -->
            <div class="control-group">
                    <label class="control-label" for="bulan">Bulan :</label>
                    <select name="bulan">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                <label class="control-label" for="nama">Tahun :</label>
                    <select name="tahun" id="tahun">
                    </select>
                    <input type="submit" class="btn btn-primary" name ="cari" value="Cari" id="cari">
                </div>
        </form>
                <table class="table table-bordered">
                        <thead>
                                <tr>
                                        <th>Nama</th>
                                        <th>Poin Bulan Ini</th>
                                </tr>
                        </thead>

                                <?php
                                if($stmt->rowCount() > 0) {
                                        foreach ($data as $sales) {
                                ?>

                        <tbody>
                                <tr>
                <td><a href="<?php echo homeUrl; ?>dealer/sales/karyawan/edit-karyawan.php?id=<?php echo $sales['id']?>"><?php echo strtoupper($sales['nama']); ?></a></td>

                                        <?php
                                                $query = "SELECT nama FROM point_sales
                                                        WHERE nama='".$sales['nama']."'
                                                        AND month(tgl_simpan)=month(now())
                                                        AND year(tgl_simpan)=year(now())
                                                        AND status_poin=1";

                    if (isset($_POST['cari'])) {
                        $bulan = $_POST['bulan'];
                        $tahun = $_POST['tahun'];

                        $query = "SELECT nama FROM point_sales
                                                        WHERE nama='".$sales['nama']."'
                                                        AND month(tgl_simpan)='".$bulan."'
                                                        AND year(tgl_simpan)='".$tahun."'
                                                        AND status_poin=1";
                    }
                        $run = $conn->prepare($query);
                                                $run->execute();
                                                $poin = count($run->fetchAll());
                                         ?>

                                        <td><?php echo $poin; ?></td>

                                        <?php
                                                        }
                                                }
                                        ?>

                                </tr>
                        </tbody>
        </table>
        </div>
<script type="text/javascript">
var start = 2015;
var end = new Date().getFullYear();
var options = "";
for(var year = start ; year <=end; year++){
  options += "<option value="+ year +">"+ year +"</option>";
}
document.getElementById("tahun").innerHTML = options;
</script>
