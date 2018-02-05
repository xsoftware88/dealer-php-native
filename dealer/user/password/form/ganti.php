<?php
session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../../login/login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    include '../../../menu/reminder.php';
}
?>


<div class="container-fluid">
    <form class="form-horizontal" action='/dealer/bengkel/user/password/form-proses/ganti.php' method="POST">
        <fieldset>
            <div id="legend">
                <legend class="">Ganti Password</legend>
            </div>
            <div class="control-group">
                <!-- Password-->
                <label class="control-label" for="oldpassword">Password Lama</label>
                <div class="controls">
                    <input type="password" id="oldpassword" name="oldpassword" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <!-- Password-->
                <label class="control-label" for="password">Password Baru</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
