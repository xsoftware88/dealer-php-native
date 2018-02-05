<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo homeUrl; ?>dealer/index.php">HOME</a>
            <a class="brand" href="<?php echo homeUrl; ?>dealer/gudang/index.php?p=adm">GUDANG</a>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        DRIVER
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/gudang/driver/index.php">UNIT KIRIM</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        PDC
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/gudang/pdc/index.php">UNIT DISIAPKAN</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        PDS
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">
                                <span class="glyphicon glyphicon-log-out"></span> OTEHER LINK
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        <?php echo $_SESSION['username'];?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!--a href="/dealer/bengkel/service/remminder/reminder-kpi.php">Point Reminder</a -->
                            <a href="<?php echo homeUrl; ?>dealer/user/password/form/ganti.php">Ganti Password</a>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo homeUrl; ?>dealer/user/login/form-proses/logout.php">
                        <span class="glyphicon glyphicon-log-out"></span> LOGOUT
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>
