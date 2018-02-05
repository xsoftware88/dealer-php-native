<?php
include '../../../../conf/conf.php';
session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "/dealer/bengkel/login/login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    //include '../../../menu/reminder.php';
}
echo "<pre>";

if (!isset($_POST['pkb'])) {
    echo 'data non remminder <br>';
    var_dump($_POST);
    include __DIR__ . '/appoitment-non-remminder.php';
} else {
    echo 'data dari remminder <br>';
    include __DIR__ . '/appoitment-dari-remminder.php';
}
