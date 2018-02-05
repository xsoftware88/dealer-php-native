<?php
session_start();
include '../../../../conf/conf.php';
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "/dealer/bengkel/login/login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    include '../../../menu/reminder.php';
}
?>

<script type="text/javascript">
    $(function(){
        $('*[name=datang]').appendDtpicker({
            "closeOnSelected": true,
            "futureOnly": true,
            "minTime":"08:00",
            "maxTime":"15:30"
        });
    });
    $(function(){
        $('*[name=penyerahan]').appendDtpicker({
            "closeOnSelected": true,
            "futureOnly": true,
            "minTime":"09:00",
            "maxTime":"16:30"
        });
    });
    //~ $("#stall").keyup(function(e){
    $(function(){
        //~ $('#displayResults').hide();
        $('#tipeOrder').click(function() {
            valtipeOrder = $('#tipeOrder').find(':selected').val();
            valDatang    = $('#datang').val();
            valAkhir     = $('#penyerahan').val();
            console.log($(this).val());
            $.ajax({
                url : "/dealer/bengkel/service/papan-kontrol/form-proses/cek-stall.php",
                type: "post",
                data: {
                    datang : valDatang,
                    penyerahan : valAkhir,
                    tipeOrder : valtipeOrder
                },
                success:function(result) {
                    console.log(result);
                    $("#displayResults").html(result);
                },
                error: function(xhr, Status, err) {
                    //$("Terjadi error : "+Status);
                    console.log("Terjadi error : "+Status);
                }
            });
            return false;//*/displayResults
        });
        $('#opl').click(function() {
            valtipeOrder = $('#tipeOrder').find(':selected').val();
            valOpl       = $('#opl').find(':selected').val();
            valDatang    = $('#datang').val();
            valAkhir     = $('#penyerahan').val();
            console.log($(this).val());
            $.ajax({
                url : "/dealer/bengkel/service/papan-kontrol/form-proses/cek-stall.php",
                type: "post",
                data: {
                    datang : valDatang,
                    penyerahan : valAkhir,
                    tipeOrder : valtipeOrder,
                    opl : valOpl
                },
                success:function(result) {
                    console.log(result);
                    $("#displayResults").html(result);
                },
                error: function(xhr, Status, err) {
                    //$("Terjadi error : "+Status);
                    console.log("Terjadi error : "+Status);
                }
            });
            return false;//*/
        });
        $('#servicePlus').click(function() {
            valtipeOrder = $('#tipeOrder').find(':selected').val();
            valOpl       = $('#opl').find(':selected').val();
            valServicePs = $('#servicePlus').find(':selected').val();
            valDatang    = $('#datang').val();
            valAkhir     = $('#penyerahan').val();
            console.log($(this).val());
            $.ajax({
                url : "/dealer/bengkel/service/papan-kontrol/form-proses/cek-stall.php",
                type: "post",
                data: {
                    datang : valDatang,
                    penyerahan : valAkhir,
                    tipeOrder : valtipeOrder,
                    opl : valOpl,
                    servicePlus : valServicePs
                },
                success:function(result) {
                    console.log(result);
                    $("#displayResults").html(result);
                },
                error: function(xhr, Status, err) {
                    //$("Terjadi error : "+Status);
                    console.log("Terjadi error : "+Status);
                }
            });
            return false;//*/
        });
        $('#stall').click(function() {
            console.log($(this).val());
            //alert($(this).val());
        });
        $('#stall').change(function() {
            //~ if ($(this).find(':selected').val() === '5') {
                //~ $('div#custom_proptions').slideDown('slow');
            //~ } else {
                //~ $('div#custom_proptions').slideUp('slow');
            //~ }
            console.log($(this).find(':selected').val());
            alert($(this).find(':selected').val());
        });
    });
</script>

<div class="span6">
    <form class="form-horizontal" action='/dealer/bengkel/service/appoitment/form-proses/input.php' method="POST">
        <fieldset>
            <div id="legend">
                <legend class="">PROSSES APPOITMENT</legend>
            </div>
            <div class="control-group">
                <label class="col-md-4 control-label"  for="nopol">NOPOL : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="nopol" name="nopol" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label class="col-md-4 control-label"  for="noka">NOKA : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="noka" name="noka" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label class="col-md-4 control-label"  for="pembawa">PEMBAWA MOBIL : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="pembawa" name="pembawa" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label class="col-md-4 control-label"  for="tlpPembawa">TELEPHON : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="tlpPembawa" name="tlpPembawa" placeholder="" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label class="col-md-4 control-label"  for="keluhan">KELUHAN : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="keluhan" name="keluhan" placeholder="" class="input-xlarge">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="datang">JANJI KEDATANGAN : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="datang" name="datang" placeholder="" class="input-xlarge">
                </div>
                <br />
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="tipeOrder">TIPE ORDER : &nbsp;</label>
                <div class="col-md-4">
                    <select id="tipeOrder" name="tipeOrder" class="form-control">
                        <option value="">=======================</option>
                        <option value="sbi">SBI</option>
                        <option value="sbe 10k">SBE 10.000</option>
                        <option value="sbe 20k">SBE 20.000</option>
                        <option value="sbe 30k">SBE 30.000</option>
                        <option value="sbe 40k">SBE 40.000</option>
                        <option value="sbe 50k">SBE 50.000</option>
                        <option value="sbe other">SBE Other</option>
                        <option value="grr ringan">GRR RINGAN</option>
                        <option value="grr berat">GRR BERAT</option>
                        <option value="twc">TWC</option>
                        <option value="engine tuneup">ENGINE TUNEUP</option>
                        <option value="return">RETURN</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="opl">OPL : &nbsp;</label>
                <div class="col-md-4">
                    <select id="opl" name="opl" class="form-control">
                        <option value="">=======================</option>
                        <option value="sporing balancing">SPORING BALANCING</option>
                        <option value="sporing">SPORING</option>
                        <option value="balancing">BALANCING</option>
                        <option value="ac">AC</option>
                        <option value="non opl">NON OPL</option>
                        <option value="other">OTHER</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="servicePlus">SERVICE+ : &nbsp;</label>
                <div class="col-md-4">
                    <select id="servicePlus" name="servicePlus" class="form-control">
                        <option value="">=======================</option>
                        <option value="wetlook">WETLOOK</option>
                        <option value="cuci">CUCI</option>
                        <option value="other">OTHER</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="stall">STALL : &nbsp;</label>
                <div class="col-md-4">
                    <select id="stall" name="stall" class="form-control">
                        <option value="">=======================</option>
                        <option value="stall 1">STALL 1</option>
                        <option value="stall 2">STALL 2</option>
                        <option value="stall 3">STALL 3</option>
                        <option value="stall 4">STALL 4</option>
                        <option value="stall 5">STALL 5</option>
                        <option value="stall 6">STALL 6</option>
                        <option value="stall 7">STALL 7</option>
                        <option value="stall 8">STALL 8</option>
                        <option value="lorong 1">LORONG 1</option>
                        <option value="lorong 2">LORONG 2</option>
                        <option value="lorong 3">LORONG 3</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <br />
                <label class="col-md-4 control-label" for="penyerahan">JANJI PENYERAHAN : &nbsp;</label>
                <div class="col-md-4">
                    <input type="text" id="penyerahan" name="penyerahan" placeholder="" class="input-xlarge">
                </div>
            </div>

            <div class="form-group">
                <br />
                <label class="col-md-4 control-label" for="simpan"> </label>
                <div class="">
                    <input type="submit" id="simpan" name="simpan" class="btn" value="Simpan">
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="span6" id="stall-list">
    <legend class="">Estimasi Waktu</legend>
    <div id="displayResults"></div>
    <div id="legend">
        <legend class="">STALL</legend>
        <?php
        $sql  = "SELECT nopol, stall, janji_kedatangan
            FROM service_data_papan_kontrol
            WHERE DATE(janji_kedatangan) = CURDATE()
            AND stall IS NOT NULL";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rowData  = $stmt->rowCount();
        $data     = $stmt->fetchAll();

        //var_dump($data);
        foreach ($data as $val) {
            echo ' NOPOL : <b>' . $val['nopol'] . '</b>';
            echo ' | STALL <b>: ' . $val['stall'] . '</b>';
            echo ' | DATANG <b>: ' . $val['janji_kedatangan'] . '</b>';
            echo '<br>';
        }
        ?>
    </div>
</div>
