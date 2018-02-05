<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

<script src="../../asset/js/jquery.min.js"></script>
<script src="../../asset/js/jquery.validate.min.js"></script>
<script src="../../asset/js/bootstrap.min.js"></script>

<div class="container-fluid">
    <form class="form-horizontal" action='login-proses.php' method="POST">
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
