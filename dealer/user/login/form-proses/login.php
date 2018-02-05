<?php
session_start();

include __DIR__ . '/../../../conf/conf.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_GET['p'])) {
    if ($_POST['username'] != "" && $_POST['password'] != "" && $_GET['p'] != "") {
        cekUser ($mysqli, $conn, $_POST);
        redirectModul ($_SESSION['modul']);
        //redirectModul ($_GET['p']);
    }
} else if (isset($_SESSION['username']) && isset($_GET['p'])) {
    if ($_GET['p'] != "") {
        redirectModul ($_GET['p']);
    } else {
        //do someting
        echo 'someting error';
    }
} else {
    //do someting
    echo 'someting error';
}

function cekUser ($mysqli, $conn, $postData) {

    $username = mysqli_real_escape_string($mysqli,strtoupper($postData['username']));
    $password = mysqli_real_escape_string($mysqli,strtoupper($postData['password']));

    $username = rtrim($username, ' ');

    $sqlLogin = "SELECT *
        FROM `master_login`
        WHERE username = '".$username."'
        AND password = '".md5($password)."'";

    $stmt = $conn->prepare($sqlLogin);
    $stmt->execute();
    $countLogin = $stmt->rowCount();

    if ($countLogin != 0) {
        $dataLogin = $stmt->fetchAll();
        $modul = $dataLogin[0]['modul'];
        // buat session
        $_SESSION['username'] = $username;
        $_SESSION['cabang']   = $dataLogin[0]['cabang'];
        $_SESSION['modul']    = $dataLogin[0]['modul'];
    } else {
        //do someting
        echo 'someting error';
        exit;
    }
}

function redirectModul ($modul) {
    if ($modul == 'driver') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/gudang/index.php?p=".$modul."';
        </script>";
            //window.location = 'http://".$_SERVER['HTTP_HOST']."/dealer/user/login/form/login.php'
        //window.location = '../gudang/tampil.php';
    } elseif ($modul == 'pdc') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/gudang/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'pds') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/gudang/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'gudang') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/gudang/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'admho') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/adm/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'adm') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/adm/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'admin') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/sales/index.php?p=".$modul."';
        </script>";
    //window.location = '../sales/admin/tampil.php';
    } elseif ($modul == 'sales') {
        //var_dump(homeUrl."dealer/sales/index.php?p=".$modul);exit;
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/sales/index.php?p=".$modul."';
        </script>";//*/
    } elseif ($modul == 'driver') {
        echo "<script type='text/javascript'>
            window.location = '../driver/tampil.php';
        </script>";
    } elseif ($modul == 'kepala_cabang') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/sales/index.php?p=".$modul."';
        </script>";
            //window.location = '".homeUrl."dealer/sales/kacab/tampil.php';
    } elseif ($modul == 'su') {
        echo "<script type='text/javascript'>
            window.location = '../hrd/daftar-karyawan.php';
        </script>";
    } elseif ($modul == 'hrd') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/hrd/index.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'stok') {
        echo "<script type='text/javascript'>
            window.location = '../stok/tampil-stok.php';
        </script>";
    } elseif ($modul == 'bengkel') {
        echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/bengkel/service/remminder/reminder-list.php?p=".$modul."';
        </script>";
    } elseif ($modul == 'gm') {
        echo "<script type='text/javascript'>
            window.location = '../../../gm/report.php';
        </script>";
    }  //window.location = "../service/remminder/reminder-list.php";
}
