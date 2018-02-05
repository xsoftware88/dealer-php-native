              <div class="box box-info">
                <div class="box-header">
                  <i class="fa fa-envelope"></i>
                  <h3 class="box-title">Quick SMS</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <form action="" method="post">
                    <div class="form-group">
                      <input type="number" class="form-control" name="a" placeholder="Phone Number..." required>
                    </div>
                    <div>
                      <textarea name='b' placeholder="Write a Message..." onKeyDown="textCounter(this.form.b,this.form.countDisplay);" onKeyUp="textCounter(this.form.b,this.form.countDisplay);" style="width: 100%; height: 205px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                      <input type='number' name='countDisplay' size='3' maxlength='3' value='160' style='width:25%; text-align:center; border:1px solid #cecece' readonly> Sisa Karakter
                    </div>
                      <?php 
                        if (isset($_POST[kirim])){
                          if (isset($_POST[kirim])){
                            $m = mysql_fetch_array(mysql_query("SELECT ID FROM phones ORDER BY ID DESC LIMIT 1"));
                            $hasil = mysql_query("INSERT INTO outbox (DestinationNumber, SenderID, TextDecoded, CreatorID) VALUES ('$_POST[a]', '$m[ID]', '$_POST[b]', 'Gammu 1.28.90')");
                            if ($hasil){
                              echo "<center style='color:green; padding:15px 0px'>Success! - Pesan SMS Telah dikirim,...</center>";
                            }else{
                              echo "<center style='color:red; padding:15px 0px'>Pengiriman SMS gagal,...</center>";
                            }
                          }
                        }
                      ?>
                </div>
                <div class="box-footer clearfix">
                  <button type='submit' name='kirim' class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                </form>
              </div>
