<div class="box box-success">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-comments-o"></i>
              <h3 class="box-title">Inbox</h3>
              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                </div>
              </div>
            </div>
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 360px;">
            <div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto; height: 360px;">
              <?php 
                $smsq = mysql_query("SELECT * FROM sms_inbox ORDER BY id DESC LIMIT 5");
                while($r=mysql_fetch_array($smsq)){
                    $nohp = str_replace('+62','0',$r[nohp]);
                    echo "<div class='item'>
                            <img src='dist/img/users.gif' alt='user image' class='online'>
                            <p class='message'>
                              <a href='index.php?view=sms&nohp=$nohp' class='name'>
                                <small class='text-muted pull-right'><i class='fa fa-clock-o'></i> $r[waktu]</small>
                                $r[nohp]
                              </a>
                              $r[pesan]
                            </p>
                          </div>";
                }
              ?>
            </div>
            </div>
            <!-- /.chat -->

          </div>