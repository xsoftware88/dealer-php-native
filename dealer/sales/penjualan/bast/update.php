<?php
/*session_start();

if (empty($_SESSION['username'])) {
    ?>
    <script type="text/javascript">
        window.location = "../../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}

        include __DIR__ . "/../../conf/conf.php";
*/
include __DIR__ . "/../../head.php";

if(isset($_POST['update'])) {
        
        if ($_POST['kota'] == 'Surabaya') {
                $rangeArea = 1;
        } else if ($_POST['kota'] == 'Gresik' || $_POST['kota'] == 'Sidoarjo') {
                $rangeArea = 2;
        } else {
                $rangeArea = 3;
        }

$id = $_POST['id'];
$jam = $_POST['jam'];
$spk = $_POST['spk'];
$tglSpk = $_POST['tgl_spk'];
$jenisPenjualan = $_POST['jenis'];
$leasing = $_POST['leasing'];
$nama = $_POST['nama_cust'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$kecamatan = $_POST['kecamatan'];
$gesekan = $_POST['gesekan'];
$driver = $_POST['optionsRadios'];
$telp = $_POST['telp'];
$emailCust = $_POST['email'];
$npwp = $_POST['npwp'];
$noka = $_POST['noka'];
$nosin = $_POST['nosin'];
$bast = $_POST['bast'];
$tglBast = $_POST['tgl_bast'];
$tipe = $_POST['tipe'];
$warna = $_POST['warna'];
$tahun = $_POST['tahun'];
$nopol = $_POST['nopol'];
$variasi = $_POST['variasi'];
$spv = $_SESSION['username'];
$cabang = $_SESSION['cabang'];

$max = "SELECT jam_kirim FROM sales_unit_kirim
            WHERE year(jam_kirim)=year('".$jam."')
            AND month(jam_kirim)=month('".$jam."')
            AND day(jam_kirim)=day('".$jam."')";
$cek = $conn->prepare($max);
$cek->execute();
$jumlah = $cek->fetchAll();
$maxKirim = count($jumlah);

                //echo "<pre>";
                //var_dump($jumlah);
                //exit;

        if($maxKirim < 18) {

        $update = "UPDATE sales_unit_kirim
                        SET jam_kirim='".$jam."',
                            driver='".$driver."',
                            nomor_spk='".$spk."',
                			tgl_spk='".$tglSpk."',
                			jenis_penjualan='".$jenisPenjualan."',
                			leasing='".$leasing."',
                			nama_cust='".$nama."',
                            alamat_cust='".$alamat."',
                            kota_cust='".$kota."',
                			kecamatan_cust='".$kecamatan."',
                            gesekan='".$gesekan."',
                			range_area='".$rangeArea."',
                            nomor_telp='".$telp."',
                			email_cust='".$emailCust."',
                			npwp_cust='".$npwp."',
                            noka='".$noka."',
                			nosin='".$nosin."',
                            nomor_bast='".$bast."',
                            type_unit='".$tipe."',
                			warna_unit='".$warna."',
                			tahun_unit='".$tahun."',
                			nopol_unit='".$nopol."',
                            variasi='".$variasi."',
                            tgl_update= now(),
                            user='".$spv."'
                            WHERE id='".$id."'";
                        $stmt = $conn->prepare($update);
                        $stmt->execute();

                        if($stmt->rowCount() > 0) {
                                echo "<script type='text/javascript'>
                                        window.location = 'index.php';
                                        </script>";
                        }
                } else {
                        //echo "Jadwal padat. Silahkan pilih tanggal yang lain. <a href='tampil.php'>Kembali</a>";
        ?>
<script type="text/javascript">
        if(confirm("Jadwal Padat. Silahkan pilih tanggal yang lain")) {
        //window.location = '';
    <?php
        $update = "UPDATE sales_unit_kirim
                        SET jam_kirim='".$jam."',
                          	driver='".$driver."',
                            nomor_spk='".$spk."',
                			tgl_spk='".$tglSpk."',
                			jenis_penjualan='".$jenisPenjualan."',
                			leasing='".$leasing."',
                			nama_cust='".$nama."',
                            alamat='".$alamat."',
                            kota='".$kota."',
                			kecamatan='".$kecamatan."',
                            gesekan='".$gesekan."',
                			range_area='".$rangeArea."',
                            nomor_telp='".$telp."',
                			email_cust='".$emailCust."',
                			npwp_cust='".$npwp."',
                            noka='".$noka."',
                			nosin='".$nosin."',
                            nomor_bast='".$bast."',
                            type_unit='".$tipe."',
                			warna_unit='".$warna."',
                			tahun_unit='".$tahun."',
                			nopol_unit='".$nopol."',
                            variasi='".$variasi."',
                            tgl_update= now(),
                            user='".$user."'
                            WHERE id='".$id."'";

                        $stmt = $conn->prepare($update);
                        $stmt->execute();

    ?>
        window.location = 'index.php';
    } else {
        window.location = 'edit.php?id=<?php echo $id;?>';
    }
</script>
<?php

                        /*if($stmt->rowCount() > 0) {
                                echo "<script type='text/javascript'>
                                        window.location = 'tampil.php';
                                        </script>";
                        } */
        }
    } elseif (isset($_POST['hapus'])) {
                $id = $_POST['id'];

                $statement = "UPDATE sales_unit_kirim,point_sales 
                                SET sales_unit_kirim.hapus=1,
                                    point_sales.status_poin=0
                                WHERE sales_unit_kirim.id='".$id."'
                                AND sales_unit_kirim.nomor_spk=point_sales.nomor_spk";
                $stmt = $conn->prepare($statement);
                $stmt->execute();

                echo "<script type='text/javascript'>
                                        window.location = 'index.php';
                                        </script>";

        }
