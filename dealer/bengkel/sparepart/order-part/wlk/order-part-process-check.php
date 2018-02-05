<?php
include '../../../../conf/conf.php';

if (isset($_POST['proses']) && !empty($_POST['nomerOrder']) && !empty($_POST['tipeOrder'])) {
//edit data
    $dataSelect = "SELECT * FROM part_order_tam_temp WHERE cabang = 'WLK' AND kode_order LIKE '%".$_POST['nomerOrder']."%'";
    $stmt = $conn->prepare($dataSelect);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $val) {
        if (($_POST['tipeOrder'] == '1') OR ($_POST['tipeOrder'] == '2')) {
            $tmp = substr($val["kode_order"], 0, 46);
            $tmp = $tmp . '9' . $_POST['tipeOrder'] . '                    K';
        }
        if (($_POST['tipeOrder'] == '3') OR ($_POST['tipeOrder'] == 'C')) {
            $tmp = substr($val["kode_order"], 0, 46);
            $tmp = $tmp . '9' . $_POST['tipeOrder'];
        }

        $sql = "UPDATE part_order_tam_temp SET kode_order='".$tmp."' WHERE cabang = 'WLK' AND kode_order LIKE '%".$_POST['nomerOrder']."%'";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // execute the query
        $stmt->execute();
    }
    echo '<script type="text/javascript">
        document.getElementById("nomerOrder").value = "'.$_POST['nomerOrder'].'";
        document.getElementById("tipeOrder").value = "'.$_POST['tipeOrder'].'";
    </script>';
}
//~ if (isset($_POST['cetakText']) && !empty($_POST['nomerOrder']) && !empty($_POST['tipeOrder'])) {
if (isset($_POST['cetakText'])) {
//cetak data ambil dari database

    //$file = "C:\\xampp\\htdocs\\bengkel\\temp\\text/order-part-tam.txt";
    $file = '/var/www/html/dealer/bengkel/sparepart/order-part/tmp/order-part-tam.txt';
    $f = fopen($file, 'w'); // Open in write mode

    $dataSelect = "SELECT * FROM part_order_tam_temp WHERE cabang = 'WLK'";
    $stmt = $conn->prepare($dataSelect);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $val) {
        $dataPrint = $val['kode_order'] ."\r\n";
        //~ $numberNewline = $number . "\n";
        //~ fwrite($file, $numberNewline);
        fwrite($f, $dataPrint);

        // hapus data
        $dataSelect = "DELETE FROM part_order_tam_temp WHERE kode_order = '".$val['kode_order']."'";
        $stmt = $conn->prepare($dataSelect);
        $stmt->execute();
    }

    fclose($f);
?>
    <script type="text/javascript">
        window.location = "http://192.168.0.2/dealer/bengkel/sparepart/order-part/wlk/order-part-cetak-txt.php";
    </script>
<?php
}

echo '<form method="post" action="">
    <label class="col-md-4 control-label" for="nomerOrder">Cari&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<label>
    <input id="nomerOrder" name="nomerOrder" type="text" placeholder="Nomer Order" class="form-control input-md">
    <br />
    <label class="col-md-4 control-label" for="tipeOrder">Tipe Order&nbsp</label>
    <select id="tipeOrder" name="tipeOrder" class="form-control">
        <option value="">===</option>
        <option value="1"> 1 </option>
        <option value="2"> 2 </option>
        <option value="3"> 3 </option>
        <option value="C"> C </option>
    </select>
    <br /><br />
    <input name="proses" type="submit" value="Proses">
    <input name="cetakText" type="submit" value="Cetak Text">
</form><br /><br />======================================<br /><br />';



if (isset($_POST['proses']) || isset($_POST['cetakText'])) {
    $dataSelect = "SELECT * FROM part_order_tam_temp WHERE cabang = 'WLK'";
    $stmt = $conn->prepare($dataSelect);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $val) {
        echo $val["kode_order"] .'<br />';
    }
    //~ if (isset($_POST['cetakText'])){
        //~ // hapus data di db
    //~ }
} else if (!isset($_POST['proses']) || !isset($_POST['cetakText'])) {
    $dataSelect = "SELECT * FROM part_order_tam_temp WHERE cabang = 'WLK'";
    $stmt = $conn->prepare($dataSelect);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $val) {
        echo $val["kode_order"] .'<br />';
    }
    //~ if (isset($_POST['cetakText'])){
        //~ // hapus data di db
    //~ }
}

//echo "<a href=backups/$newcode.txt>TEST!</a>";

