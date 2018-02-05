<?php
session_start();
include '../../conf/conf.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] != "" && $_POST['password'] != "") {
        $username = mysqli_real_escape_string($mysqli,strtoupper($_POST['username']));
        $password = mysqli_real_escape_string($mysqli,strtoupper($_POST['password']));

        $sqlLogin = "SELECT *
            FROM `master_login`
            WHERE username = '".$username."'
            AND password = '".md5($password)."'";

        $stmt = $conn->prepare($sqlLogin);
        $stmt->execute();
        $countLogin = $stmt->rowCount();

        if ($countLogin != 0) {
            $dataLogin = $stmt->fetchAll();
            // buat session
            echo 'ok';
            $_SESSION['username'] = $username;
            ?>
            <script type="text/javascript">
                window.location = "../service/remminder/reminder-list.php";
            </script>
            <?php
        } else {
            // balikin ke login form
            echo 'salah';
            ?>
            <script type="text/javascript">
                window.location = "login-form.php";
            </script>
            <?php
        }
    } else {
        echo 'salah';
        ?>
        <script type="text/javascript">
            window.location = "login-form.php";
        </script>
        <?php
    }
} else {
    echo 'salah';
    ?>
    <script type="text/javascript">
        window.location = "login-form.php";
    </script>
    <?php
}
