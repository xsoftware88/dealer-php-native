<?php
    include  __DIR__ . '/../asset/asset.php';
?>

<style>
    label {
        display: inline-block;
        width: 150px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input[type="text"] {
        height: 30px;
    }
    table {
        font-size: 12px;
    }
    table, thead, tr {
        display: block;
        width: 100%;
    }
    tbody {
        width: 100%;
        overflow: auto;
        height: 200px;
        display: block;
    }
    .nopol {width: 158px;}
    .tipe {width: 85px;}
    .nama {width: 200px;}
    .alamat {width: 200px;}
    .saran {width: 200px;}
    .km {width: 60px;}
    .terakhir {width: 100px;}
    .next {width: 100px;}
    .remminder {width: 200px;}
    //th.empat {width: 355px;}
    .empat {width: 355px;}
    .imgCenter {
        margin: auto;
        display: block;
        text-align: center;
        text-align: -webkit-center;
    }
</style>

<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="/dealer/bengkel/service/remminder/reminder-list.php">Reminder</a>
            <!--ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
            </ul-->
            <ul class="nav navbar-nav pull-right">
                <li><a href="/dealer/bengkel/service/appoitment/form/input.php">
                        <span class="glyphicon glyphicon-log-out"></span> Appoitment
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><?php echo $sa;?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <!--a href="/dealer/bengkel/service/remminder/reminder-kpi.php">Point Reminder</a -->
                            <a href="/dealer/bengkel/service/report/remminder-kpi.php">Point Reminder</a>
                        </li>
                        <li>
                            <!--a href="/dealer/bengkel/service/remminder/reminder-kpi.php">Point Reminder</a -->
                            <a href="/dealer/bengkel/user/password/form/ganti.php">Ganti Password</a>
                        </li>
                    </ul>
                </li>
                <li><a href="/dealer/bengkel/login/logout.php">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
