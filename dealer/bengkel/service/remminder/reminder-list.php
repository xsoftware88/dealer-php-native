<?php
session_start();
if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login-form.php";
    </script>
    <?php
} else {
    $sa = $_SESSION['username'];
    include '../../menu/reminder.php';
}
?>

<style>
    tbody {
        height: 280px;
    }
</style>

<script>
$(document).ready(function(){
    $("#data-load").hide();
    $("#cariNopol").keyup(function(e){
        //panjangStr = $("#cariNoka").val($(this).val().length)
        if ($(this).val().length > 3) {
            valNopol = $(this).val();
            console.log($(this).val());
            $("#data-load").show();
            $("#LoadingImage").show();
            $("#tabel-data").hide();
            e.preventDefault();
            $.ajax({
                url : "reminder-list/byNopol.php",
                type: "post",
                data: {nopol : valNopol},
                success:function(result) {
                    $("#LoadingImage").hide();
                    $("#tabel-data").show();
                    //console.log(result);
                    $("#displayResults").html(result);
                },
                error: function(xhr, Status, err) {
                    $("#LoadingImage").hide();
                    $("Terjadi error : "+Status);
                }
            });
            return false;//*/
        }
    });
    $("#cariNoka").keyup(function(e){
        //panjangStr = $("#cariNoka").val($(this).val().length)
        if ($(this).val().length > 8) {
            valNoka = $(this).val();
            console.log($(this).val());
            $("#data-load").show();
            $("#LoadingImage").show();
            $("#tabel-data").hide();
            e.preventDefault();
            $.ajax({
                url : "reminder-list/byNoka.php",
                type: "post",
                data: {noka : valNoka},
                success:function(result) {
                    $("#LoadingImage").hide();
                    $("#tabel-data").show();
                    //console.log(result);
                    $("#displayResults").html(result);
                },
                error: function(xhr, Status, err) {
                    $("#LoadingImage").hide();
                    $("Terjadi error : "+Status);
                }
            });
            return false;//*/
        }
    });
    $("#cariData").click(function(e){
        $("#data-load").show();
        $("#LoadingImage").show();
        $("#tabel-data").hide();
        e.preventDefault();
        if ($("#selectCari").val() === "") {
            alert('Pilih dahulu yang mau dicari');
            $("#LoadingImage").hide();
            e.preventDefault();
        } else {
            $("#cariData").click(function(e){
                e.preventDefault();
                $.ajax({
                    url : "form-proses/reminder-proses-list.php",
                    type: "post",
                    data: $("#formCari").serialize(),
                    success:function(result) {
                        $("#LoadingImage").hide();
                        $("#tabel-data").show();
                        //console.log(result);
                        $("#displayResults").html(result);
                    },
                    error: function(xhr, Status, err) {
                        $("#LoadingImage").hide();
                        $("Terjadi error : "+Status);
                    }
                });
                return false;
            });
        }
    });
});
</script>

<?php
include 'form/reminder-list-form.php';
?>


<div id="data-load">
    <div id="LoadingImage" style="display: none">
        <img class="imgCenter" src="../../../asset/bootstrap/img/loading-batman.gif" />
        <div class="imgCenter" >Jika load terlalu lama, coba untuk klik cari kembali</div>
    </div>
    <div class="table-wrapper" id="tabel-data">
        <div class="table-scroll">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th class="">
                            NO
                        </th>
                        <th class="nopol">
                            NOPOL/
                            NOKA/
                            Handle
                        </th>
                        <th class="nama">
                            NAMA /
                            PHONE
                        </th>
                        <th class="alamat">
                            ALAMAT
                        </th>
                        <th class="km">
                            KM &nbsp; &nbsp; &nbsp; / KM NEXT
                        </th>
                        <th class="terakhir">
                            TERAKHIR / NEXT SERVICE
                        </th>
                        <th class="remminder">
                            REMINDER
                        </th>
                        <th class="saran">
                            SARAN PKB / SARAN REMINDER
                        </th>
                    </tr>
                </thead>
                <tbody id="displayResults">
                </tbody>
            </table>
        </div>
    </div>
</div>
