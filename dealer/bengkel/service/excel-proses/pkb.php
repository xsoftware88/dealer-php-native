<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', 300000);
include '../../../conf/conf.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//$inputFileName = 'Book1.xls';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB 2013 - JULI 17 LENGKAP PARTS DAN BAHAN.xlsx';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB.xls';
$inputFileName = '../../../temp/upload/bengkel/excel/PKB.xls';

//  Read your Excel workbook
try {
    $inputFileType   = PHPExcel_IOFactory::identify($inputFileName);
    $objReader       = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel     = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$sheet          = $objPHPExcel->getSheet(0);
$highestRow     = $sheet->getHighestRow();
$highestColumn  = $sheet->getHighestColumn();

$i              = 0;
$tmp1           = '';
$tmp2           = '';
$listData       = array();

echo "<pre>";
for ($row = 2; $row <= $highestRow; $row++) {
$rowData = $sheet->rangeToArray('B' . $row . ':Y' . $row,
                                null, true, false);
//var_dump($rowData[0]);exit;
    $nopkb      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $tglpkb     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][1]));
    $nopol      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));
    $noka       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][3]));

    $merek      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][4]));
    $tipe       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][5]));

    $kmSekarang = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][6]));
    $nama       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][7]));
    $alamat     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][8]));
    $telpon     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][9]));
    $keluhan    = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][10]));
    $diagnosa   = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][11]));
    $saran      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][12]));
    $sa         = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][13]));

    $tglpkb      = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tglpkb));

    $tempdata   = explode(" / ", $rowData[0][5]);

    if (isset($tempdata[0]) and isset($tempdata[1]) and isset($tempdata[2])) {
        $warna = strtoupper($tempdata[0]);
        $tahun = strtoupper($tempdata[1]);
        $model = strtoupper($tempdata[2]);
    } else {
        $warna = strtoupper($tempdata[0]);
        $tahun = '-';
        $model = '-';
    }

    $sqlPkb = "SELECT *
    FROM service_data_pkb_full
    WHERE noka ='".$noka."'
    ORDER BY `service_data_pkb_full`.`tanggal_pkb` DESC limit 1";

    $stmt = $conn->prepare($sqlPkb);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
            $sql = "INSERT INTO service_data_pkb_full
            (nomor_pkb, tanggal_pkb, nopol, noka, km, nama, alamat, phone, keluhan, diagnosa, saran, sa)
            VALUES (
            '".$nopkb."',
            '".$tglpkb."',
            '".$nopol."',
            '".$noka."',
            '".$kmSekarang."',
            '".$nama."',
            '".$alamat."',
            '".$telpon."',
            '".$keluhan."',
            '".$diagnosa."',
            '".$saran."',
            '".$sa."')";
            //~ var_dump($sql);exit;
            $conn->exec($sql);
            $idVehicle = $conn->lastInsertId();

            $sql = "INSERT INTO service_data_pkb_last
            (nomor_pkb, tanggal_pkb, nopol, noka, km, nama, alamat, phone, keluhan, diagnosa, saran, sa)
            VALUES (
            '".$nopkb."',
            '".$tglpkb."',
            '".$nopol."',
            '".$noka."',
            '".$kmSekarang."',
            '".$nama."',
            '".$alamat."',
            '".$telpon."',
            '".$keluhan."',
            '".$diagnosa."',
            '".$saran."',
            '".$sa."')";
            //~ var_dump($sql);exit;
            $conn->exec($sql);
            $idVehicle = $conn->lastInsertId();

            echo $i."  insert new ".$noka."<br />";
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    } else {
        // check nomer pkb jika tidak sama, maka insert
        $sqlNoPkb = "SELECT nomor_pkb
        FROM service_data_pkb_full
        WHERE nomor_pkb ='".$tglpkb."'";

        $stmt = $conn->prepare($sqlNoPkb);
        $stmt->execute();
        $rowNoPkb  = $stmt->rowCount();
        $dataNoPkb = $stmt->fetchAll();

        $tglAwal  = new DateTime($dataPkb[0]['tanggal_pkb']);
        $tglAkhir = new DateTime($tglpkb);
        $diff     = date_diff( $tglAwal, $tglAkhir );
        $jmlHari  = (int)$diff->days;

        $tglNext  = date('Y-m-d', strtotime('+'.$jmlHari.' days', strtotime($tglAkhir->format("Y-m-d"))));
        $jmlKM    = (int)$kmSekarang - (int)$dataPkb[0]['km'];

        if ($jmlKM != 0 && $jmlHari !=0) {
            $rataRata = (int)$jmlKM / (int)$jmlHari;
            $rataRata = ceil($rataRata);
            if ($rataRata <= 56) {
                // rata" default 10.000 / 180 = 55.55 dibulatkan 56
                // tanggal next service maju di hitung jadi default 180 hari atau 6 bln
                $rataRata = 56;
                $jmlHari = ceil('180');
                $tglNext  = date('Y-m-d', strtotime('+'.$jmlHari.' days', strtotime($tglAkhir->format("Y-m-d"))));
            } else {
                // tanggal service maju
                $kmStd   = 10000;
                $jmlHari = $kmStd / $rataRata;
                $jmlHari = ceil($jmlHari);
                $tglNext  = date('Y-m-d', strtotime('+'.$jmlHari.' days', strtotime($tglAkhir->format("Y-m-d"))));
            }
        } else {
            $rataRata = 56;
            $jmlHari = ceil('180');
            $tglNext  = date('Y-m-d', strtotime('+'.$jmlHari.' days', strtotime($tglAkhir->format("Y-m-d"))));
        }//*/

        $nextKm = (int)$rataRata + (int)$kmSekarang;
        $nextKm = ceil($nextKm);

        if ($rowNoPkb != 0) {
            //update

            try {
                $sql = "UPDATE service_data_pkb_full
                    SET
                    nomor_pkb='".$nopkb."',
                    tanggal_pkb='".$tglpkb."',
                    tanggal_sebelumnya='".$dataPkb[0]['tanggal_pkb']."',
                    tanggal_selanjutnya='".$tglNext."',
                    nopol='".$nopol."',
                    noka='".$noka."',
                    km='".$kmSekarang."',
                    km_sebelumnya='".$dataPkb[0]['km']."',
                    nama='".$nama."',
                    alamat='".$alamat."',
                    phone='".$telpon."',
                    keluhan='".$keluhan."',
                    diagnosa='".$diagnosa."',
                    saran='".$saran."',
                    sa='".$sa."'
                    WHERE noka = '".$noka."'
                    AND nomor_pkb='".$tglpkb."'";
                $conn->exec($sql);

                $sql = "UPDATE service_data_pkb_last
                    SET
                    nomor_pkb='".$nopkb."',
                    tanggal_pkb='".$tglpkb."',
                    tanggal_sebelumnya='".$dataPkb[0]['tanggal_pkb']."',
                    tanggal_selanjutnya='".$tglNext."',
                    nopol='".$nopol."',
                    noka='".$noka."',
                    km='".$kmSekarang."',
                    km_sebelumnya='".$dataPkb[0]['km']."',
                    nama='".$nama."',
                    alamat='".$alamat."',
                    phone='".$telpon."',
                    keluhan='".$keluhan."',
                    diagnosa='".$diagnosa."',
                    saran='".$saran."',
                    sa='".$sa."'
                    WHERE noka = '".$noka."'";
                $conn->exec($sql);

                echo $i."  pkb sama ".$noka."<br />";
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        } else if ($rowNoPkb == 0) {
        //~ if ($dataPkb[0]['nomor_pkb'] != $nopkb) {
            // data tidak ada, maka insert, dengan menggabungkan data sebelumnya
            // plus estimasi next
            try {
                $sql = "INSERT INTO service_data_pkb_full
                (nomor_pkb, tanggal_pkb, tanggal_sebelumnya, tanggal_selanjutnya, nopol, noka, km, km_sebelumnya, km_selanjutnya, nama, alamat, phone, keluhan, diagnosa, saran, sa)
                VALUES (
                '".$nopkb."',
                '".$tglpkb."',
                '".$dataPkb[0]['tanggal_pkb']."',
                '".$tglNext."',
                '".$nopol."',
                '".$noka."',
                '".$kmSekarang."',
                '".$dataPkb[0]['km']."',
                '".$nextKm."',
                '".$nama."',
                '".$alamat."',
                '".$telpon."',
                '".$keluhan."',
                '".$diagnosa."',
                '".$saran."',
                '".$sa."')";
                //~ var_dump($sql);exit;
                $conn->exec($sql);
                $idVehicle = $conn->lastInsertId();

                $sql = "UPDATE service_data_pkb_last
                    SET
                    nomor_pkb='".$nopkb."',
                    tanggal_pkb='".$tglpkb."',
                    tanggal_sebelumnya='".$dataPkb[0]['tanggal_pkb']."',
                    tanggal_selanjutnya='".$tglNext."',
                    nopol='".$nopol."',
                    noka='".$noka."',
                    km='".$kmSekarang."',
                    km_sebelumnya='".$dataPkb[0]['km']."',
                    nama='".$nama."',
                    alamat='".$alamat."',
                    phone='".$telpon."',
                    keluhan='".$keluhan."',
                    diagnosa='".$diagnosa."',
                    saran='".$saran."',
                    sa='".$sa."'
                    WHERE noka = '".$noka."'";
                $conn->exec($sql);

                echo $i."  pkb tidak sama ".$noka."<br />";
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        }
    }
    $i++;
}

echo $i;
