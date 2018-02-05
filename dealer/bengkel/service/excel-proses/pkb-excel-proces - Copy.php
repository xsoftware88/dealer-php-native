<?php
ini_set('memory_limit','-1');
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
//~ var_dump($rowData[0]);exit;
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

    //$tglpkb     = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$tglpkb)));
    $tglpkb      = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tglpkb));
    //~ $kmSekarang = $kmSekarang * 1000;

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
    FROM service_data_pkb
    WHERE noka ='".$noka."'
    ORDER BY `service_data_pkb`.`tanggal_pkb` DESC limit 1";
    //~ WHERE nomor_pkb ='".$nopkb."'";

    $stmt = $conn->prepare($sqlPkb);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
            $sql = "INSERT INTO service_data_pkb
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

            echo $i."  insert new <br />";
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    } else {
        // check nomer pkb jika tidak sama, maka insert
        if ($dataPkb[0]['nomor_pkb'] != $nopkb) {
            // update data lama
            // (nomor_pkb, tanggal_pkb, nopol, noka, km, nama, alamat, phone, keluhan, diagnosa, saran, sa)
            /*try {
                $sql = "UPDATE service_data_pkb
                SET
                tanggal_selanjutnya='".$tglpkb."',
                km_selanjutnya='".$kmSekarang."'
                WHERE nomor_pkb = '".$dataPkb[0]['nomor_pkb']."'";
                $conn->exec($sql);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }*/

            // data tidak ada, maka insert, dengan menggabungkan data sebelumnya
            // plus estimasi next
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

            //~ $nextKm = $rataRata * $jmlHari;
            $nextKm = (int)$rataRata + (int)$kmSekarang;
            $nextKm = ceil($nextKm);

            //~ var_dump($tglAwal->format("Y-m-d"));
            //~ var_dump($tglAkhir->format("Y-m-d"));
            //~ var_dump($diff);
            //~ var_dump($jmlHari);
            //~ var_dump($tglNext);
            //~ var_dump($jmlKM);
            //~ var_dump($rataRata);
            //~ var_dump($kmSekarang);
            //~ var_dump($nextKm);
            //~ exit;

            try {
                $sql = "INSERT INTO service_data_pkb
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

                echo $i."  pkb tidak sama <br />";
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
            //~ var_dump($dataPkb);
            //~ var_dump($rowData);
            //~ exit;
        }
    }
    /*else {
        $tmpVehicle = $stmt->fetchAll();
        if ($tmpVehicle[0]['nopol'] != $nopol) {
            //update nopol terbaru
            try {
                $sql = "UPDATE service_vehicle
                SET nopol='".$nopol."'
                WHERE id = '".$tmpVehicle[0]['id']."'";
                $conn->exec($sql);
                $idVehicle = $conn->lastInsertId();
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
            //echo "update Nopol <br />";
        }
    }*/

    $i++;
}

echo $i;
