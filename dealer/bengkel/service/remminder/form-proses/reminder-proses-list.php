<?php
session_start();
include '../../../../conf/conf.php';
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
}

if (isset($_POST['selectCari'])) {
    if ($_POST['selectCari'] == 'byKm' || $_POST['selectCari'] == 'byKm0') {
        include '../reminder-list/byKm.php';
    }
    if ($_POST['selectCari'] == 'byKm6k') {
        include '../reminder-list/byKm6k.php';
    }
    if ($_POST['selectCari'] == 'sscPw') {
        include '../reminder-list/sscPw.php';
    }
    if ($_POST['selectCari'] == 'sscAb') {
        include '../reminder-list/sscAb.php';
    }
    if ($_POST['selectCari'] == 'byTgl') {
        include '../reminder-list/byTgl.php';
    }
    if ($_POST['selectCari'] == 'pasif79') {
        include '../reminder-list/pasif79.php';
    }
    if ($_POST['selectCari'] == 'pasif9') {
        include '../reminder-list/pasif9.php';
    }
    if ($_POST['selectCari'] == 'unremminder') {
        include '../reminder-list/unremminder.php';
    }
    if ($_POST['selectCari'] == 'unfilter') {
        include '../reminder-list/unfilter.php';
    }
    if ($_POST['selectCari'] == 'sbi') {
        include '../reminder-list/sbi.php';
    }
    if ($_POST['selectCari'] == 'tpss') {
        include '../reminder-list/tpss.php';
    }
    if ($_POST['selectCari'] == 'hasilRemminder') {
        include '../reminder-list/hasilRemminder.php';
    }
    if ($_POST['selectCari'] == 'hasilAppointment') {
        include '../reminder-list/hasilAppointment.php';
    }
    if ($_POST['selectCari'] == 'pasif') {
    }
}
