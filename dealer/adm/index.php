<?php

include __DIR__ . '/head.php';

if (!isset($_SESSION['username'])) {
    echo "<script type='text/javascript'>
            window.location = '" .homeUrl. "dealer/user/login/form/login.php?p=".$_GET['p']."'
        </script>";
} else {
    include __DIR__ . '/menu.php';
}
