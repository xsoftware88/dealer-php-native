<?php
session_start();
include '../../../../conf/conf.php';

if (isset($_SESSION['username']) && isset($_POST['oldpassword']) && isset($_POST['password'])) {
    if ($_SESSION['username'] != "" && $_POST['oldpassword'] != "" && $_POST['password'] != "") {
        $username = mysqli_real_escape_string($mysqli,strtoupper($_SESSION['username']));
        $password = mysqli_real_escape_string($mysqli,strtoupper($_POST['oldpassword']));
      
        $sqlLogin = "SELECT *
            FROM `master_login`
            WHERE username = '".$username."'
            AND password = '".md5($password)."'";

        $stmt = $conn->prepare($sqlLogin);
        $stmt->execute();
        $countLogin = $stmt->rowCount();

        if ($countLogin != 0) {
           try {
              $sqlUpdate = "UPDATE master_login
                  SET
                  password = '".md5($_POST['password'])."'
                  WHERE username = '".$username."'";
              //~ var_dump($sqlUpdateVehicle);exit;

              $stmt = $conn->prepare($sqlUpdate);
              $stmt->execute();
          }
          catch (PDOException $e) {
              echo $e->getMessage();
              break;
          }
          echo 'Ganti Password Sukses';
          echo '<br>';
          echo '<a href="/dealer/bengkel/service/remminder/reminder-list.php">Kehalaman Utama</a>';
        } else {
          echo 'Password Salah';
          echo '<br>';
          echo '<a href="/dealer/bengkel/user/password/form/ganti.php">Kembali ke Form</a>';
        }
    }
} else {
    ?>
    <script type="text/javascript">
        window.location = "../../../login/login-form.php";
    </script>
    <?php
}
