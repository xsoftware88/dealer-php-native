<?php
include __DIR__ . '/../head.php';

if (!isset($_SESSION['username']) && isset($_GET['p'])) {
    if ($_GET['p'] != "") {
?>
<div class="container-fluid">
    <form class="form-horizontal" action='<?php echo homeUrl; ?>dealer/user/login/form-proses/login.php?p=<?php echo $_GET['p']?>' method="POST">
        <fieldset>
            <div id="legend">
                <legend class="">Login</legend>
            </div>
            <div class="control-group">
                <!-- Username -->
                <label class="control-label"  for="username">Username</label>
                <div class="controls">
                    <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <!-- Password-->
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <!-- Button -->
                <div class="controls">
                    <button class="btn btn-primary">Login</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php
    } else {
        echo "<script type='text/javascript'>
                window.location = '".homeUrl."dealer/user/login/form-proses/login.php?p=".$_GET['p']."'
            </script>";
    }
} else {
    echo "<script type='text/javascript'>
            window.location = '".homeUrl."dealer/'
        </script>";
}
