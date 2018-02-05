<?php
    include  __DIR__ . '/../../../asset/asset.php';
?>

<form class="form-horizontal" action='/dealer/bengkel/service/layanan-pkb/proses/antrian-service.php' method="POST">
    <fieldset>
        <div id="legend">
            <legend class="">PROSSES ANTRIAN</legend>
        </div>
        <div class="control-group">
            <label class="col-md-4 control-label"  for="nopol">NOPOL : &nbsp;</label>
            <div class="col-md-4">
                <input type="text" id="nopol" name="nopol" placeholder="" class="input-xlarge">
            </div>
        </div>

        <div class="form-group">
            <br />
            <label class="col-md-4 control-label" for="simpan"> </label>
            <div class="col-md-4">
                <input type="submit" id="simpan" name="simpan" class="btn" value="Simpan">
            </div>
        </div>
    </fieldset>
</form>
