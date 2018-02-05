<?php

include __DIR__ . '/head.php';
//~ exit;

if (!isset($_SESSION['username'])) {
    echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/user/login/form/login.php?p=".$_GET['p']."'
        </script>";
} else {
    echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/user/login/form-proses/login.php?p=".$_GET['p']."'
        </script>";
}
