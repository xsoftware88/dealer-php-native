<?php if ($_GET[act]==''){ ?>
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Pesan Keluar </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:30px'>No</th>
                        <th>Pesan SMS</th>
                        <th style='width:90px'>Tujuan</th>
                        <th style='width:120px'>Waktu Keluar</th>
                        <!--th style='width:40px'>Status</th-->
                        <th style='width:40px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                    $tampil = mysql_query("SELECT * FROM outbox ORDER BY UpdatedInDB DESC LIMIT 500");
                    $no = 1;
                    while($r=mysql_fetch_array($tampil)){
                    echo "<tr><td>$no</td>
                              <td>$r[TextDecoded]</td>
                              <td>$r[DestinationNumber]</td>
                              <td>$r[UpdatedInDB]</td>
                              <td><center>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='index.php?view=outbox&hapus=$r[ID]'><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                          </tr>";
                      $no++;
                      }
                      if (isset($_GET[hapus])){
                          mysql_query("DELETE FROM outbox where ID='$_GET[hapus]'");
                          echo "<script>document.location='index.php?view=outbox';</script>";
                      }

                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
<?php
}
?>
