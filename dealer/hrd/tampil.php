<?php
session_start();

        include __DIR__ . "/head1.php";

        $user = $_SESSION['username'];
    $modul = $_SESSION['modul'];

        if (!empty($_SESSION['username']) && ($modul == 'hrd'))
        {

        //include __DIR__ . '/head.php';

        } else {
                echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/user/login/form/login.php?p=".$_GET['p']."'
        </script>";
        }
?>

<style>
        .table {
                font-size: 12px;
                table-layout: fixed;
                word-wrap: break-word;
        }
</style>
<div class="container-fluid">
        <div class="row-fluid">
        <form id="formCari" class="form-inline" action="" method="POST">
    <!-- Select Basic -->
        <div class="control-group">
            <div class="controls">
            <label class="control-label" for="cabang">Cabang :</label>
              <select name="cabang">
                <?php
                $query = "SELECT cabang FROM master_jabatan GROUP BY cabang";
                $sql = $conn->prepare($query);
                $sql->execute();
                $cabang = $sql->fetchAll();

                  foreach ($cabang as $pilih) { ?>
                  <option><?php echo strtoupper($pilih['cabang']); ?></option>
                  <?php
                  } ?>
              </select>
              <input type="submit" class="btn btn-primary" name ="cari" value="Cari">
              <input type="text" id="search" class="input-medium search-query pull-right" name="search" placeholder="search di sini" />
            </div>
          </div>
        </form>
<?php if (isset($_POST['cari'])) {

                        $pilihan = $_POST['cabang'];
                        $statement = "SELECT *
                                        FROM master_karyawan WHERE tempat_sekarang='".$pilihan."'";

                        $stmt = $conn->prepare($statement);
                        $stmt->execute();
                        $data = $stmt->fetchAll();
        ?>
                <table class="table table-bordered table-responsive" id="result">
                        <thead>
                                <tr>
                                        <th>Nama Karyawan</th>
                                        <th>NIK</th>
                                        <th>Jabatan</th>
                        <th>SPV</th>
                                        <th>Cabang</th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($data as $karyawan) {
                        ?>
                                <tr>
                                        <td><a href="edit-karyawan.php?id=<?php echo $karyawan['id']; ?>"><?php echo strtoupper($karyawan['nama']); ?></a></td>
                        <td><?php echo $karyawan['nik']; ?></td>
                                        <td><?php echo strtoupper($karyawan['jabatan_sekarang']); ?></td>

                                        <?php
                                $query = "SELECT nama_atasan FROM hirarki_karyawan WHERE nama_karyawan='".$karyawan['nama']."'";
                                $run = $conn->prepare($query);
                                $run->execute();
                                $atasan = $run->fetch();

                                //foreach($atasan as $spv) {
                        ?>
                        <td><?php echo strtoupper($atasan[0]); ?></td>

                        <?php// } ?>

                                        <td><?php echo strtoupper($karyawan['tempat_sekarang']); ?></td>
                                </tr>
                                <?php } ?>
                        </tbody>
                </table>
                <?php } ?>
        </div>
</div>
<script>
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
