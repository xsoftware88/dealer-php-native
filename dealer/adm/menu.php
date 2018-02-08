<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo homeUrl; ?>dealer/index.php">HOME</a>
            <a class="brand" href="<?php echo homeUrl; ?>dealer/adm/index.php?p=adm">ADMIN</a>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        UNIT
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/unit/mdb.php">MDB</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/unit/stok.php">STOK</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        UPLOAD
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/mdb.php">MDB</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/do.php">DO</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/stok.php">STOK</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/posisi-unit.php">POSISI UNIT</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/master-unit.php">MASTER UNIT</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/adm/upload/master-warna.php">MASTER WARNA</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="glyphicon glyphicon-log-out"></span> OTEHER LINK
                    </a>
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
                            <a href="/dealer/user/password/form/ganti.php">Ganti Password</a>
                        </li>
                    </ul>
                </li>
                <li><a href="/dealer/user/login/form-proses/logout.php">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>
