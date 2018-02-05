<form id="formCari" class="form-horizontal" action="" method="POST">
<fieldset>
    <div id="legend">
        <legend>Cari Reminder</legend>
    </div>
    <div class="control-group">
        <label class="control-label" for="cariNopol">Cari By NOPOL : &nbsp;</label>
        <div class="controls">
            <input type="text" id="cariNopol" name="cariNopol" class="form-control" placeholder=" nopol " class="input-xlarge">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="cariNoka">Cari By NOKA : &nbsp;</label>
        <div class="controls">
            <input type="text" id="cariNoka" name="cariNoka" class="form-control" placeholder=" noka " class="input-xlarge">
        </div>
    </div>
    <div class="control-group">
      <label class="col-md-4 control-label" for="selectCari">Cari Menurut : &nbsp;</label>
        <div class="controls">
            <select id="selectCari" name="selectCari" class="form-control">
                <option value="">=======================</option>
                <option value="byKm">Aktif By KM > 10000 dan <180 hari</option>
                <option value="byKm6k">Untuk Promo KM 60K</option>
                <option value="byTgl">Aktif By Tanggal (>150 hari s/d <180 hari)</option>
                <?php
                if ($sa == 'MRSIDR1' || $sa == 'MRSWLK1') {
                ?>
                    <option value="pasif79">Pasif 7-9 Bulan</option>
                <?php
                }
                ?>
                <option value="pasif9">Pasif 9 Bulan ++</option>
                <option value="unfilter">Data tanpa filter</option>
                <?php
                if ($sa == 'MRSIDR1' || $sa == 'MRSWLK1') {
                ?>
                    <option value="sbi">SBI</option>
                    <option value="tpss">tpss</option>
                <?php
                }
                ?>
                <option value="hasilRemminder">Hasil Remminder Saya</option>
            </select>
      </div>
    </div>
    <div class="control-group">
        <!-- Button -->
        <div class="controls">
            <input type="submit" id="cariData" name="cariData" class="btn" value="Cari">
        </div>
    </div>
</fieldset>
</form>
