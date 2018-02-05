<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo homeUrl; ?>dealer/index.php">HOME</a>
            <a class="brand" href="<?php echo homeUrl; ?>dealer/sales/index.php">
                <?php echo strtoupper(str_replace("_", " ", $_SESSION['modul'])); ?>
            </a>

            <ul class="nav navbar-nav">
            <?php if ($_SESSION['modul'] == 'sales') { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        PENJUALAN
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/penjualan/prospek/index.php">PROSPEK</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/penjualan/spk/index.php">SPK</a>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#">BAST</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo homeUrl; ?>dealer/sales/penjualan/bast/input.php">INPUT</a></li>
                                <li><a href="<?php echo homeUrl; ?>dealer/sales/penjualan/bast/index.php">VIEW</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            <?php } if ($_SESSION['modul'] == 'admin') { ?>
                <li><a href="<?php echo homeUrl; ?>dealer/sales/admin/tampil.php">BAST</a></li>
            <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        REPORT
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php if ($_SESSION['modul'] == 'sales') { ?>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/report/spv/peforma-sales.php">SPV</a>
                        </li>
                        <?php } if ($_SESSION['modul'] == 'kepala_cabang') { ?>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/report/kacab/peforma-sales-percabang.php">PERFORM SALES</a>
                        </li>
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/report/kacab/peforma-spv-percabang.php">PERFORM SPV</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php if ($_SESSION['modul'] == 'sales') { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>LAINNYA
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo homeUrl; ?>dealer/sales/karyawan/daftar-karyawan.php">TAMBAH SALES</a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
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
