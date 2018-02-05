<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', 300000);
include '../../../conf/conf.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//$inputFileName = 'Book1.xls';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB 2013 - JULI 17 LENGKAP PARTS DAN BAHAN.xlsx';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB.xls';
$inputFileName = '../../../temp/upload/bengkel/excel/PART.xls';
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
$rowData = $sheet->rangeToArray('A' . $row . ':K' . $row,
                                null, true, false);

    $nopkb      = mysql_real_escape_string(strtoupper($rowData[0][0]));
    $kodePart   = mysql_real_escape_string(strtoupper($rowData[0][1]));
    $namaPart   = mysql_real_escape_string(strtoupper($rowData[0][2]));
    $qty        = mysql_real_escape_string(strtoupper($rowData[0][3]));
    $diskon     = mysql_real_escape_string(strtoupper($rowData[0][6]));
    $harga      = mysql_real_escape_string(strtoupper($rowData[0][8]));

    $countHarga = substr_count($harga, '.');
    if ($countHarga <= 1) {
        $harga      = (int)$harga * 1000;
    } else {
        $harga      = str_replace('.', '', $harga);
    }

    //~ var_dump($rowData);
    //cek no pkb
    $sqlVehicleHistorySelect = "SELECT `id`,`nomor_pkb` FROM `service_data_pkb_full`
    WHERE nomor_pkb = '".$nopkb."'";
    $stmt = $conn->prepare($sqlVehicleHistorySelect);
    $stmt->execute();
    $rowVehicleHistorySelect = $stmt->rowCount();

    if ($rowVehicleHistorySelect != 0) {

        $sqlVehicleHistorySelect = "SELECT `nomor_pkb`, `kode_part`
            FROM `service_data_pkb_part`
            WHERE nomor_pkb = '".$nopkb."'
            AND kode_part = '".$kodePart."'";

        $stmt = $conn->prepare($sqlVehicleHistorySelect);
        $stmt->execute();

        $rowVehicleHistorySelect = $stmt->rowCount();


        if ($rowVehicleHistorySelect == 0) {
            //insert
            try {
                $sqlHistoryPart = "INSERT INTO  service_data_pkb_part (
                    nomor_pkb,
                    kode_part,
                    nama_part,
                    qty,
                    diskon,
                    harga)
                VALUES (
                    '".$nopkb."',
                    '".$kodePart."',
                    '".$namaPart."',
                    '".$qty."',
                    '".$diskon."',
                    '".$harga."')";
                $conn->exec($sqlHistoryPart);
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                break;
            }
        } else if ($rowVehicleHistorySelect != 0) {
            //update
            try {
                $sqlUpdateVehicle = "UPDATE service_data_pkb_part
                    SET
                    kode_part = '".$kodePart."',
                    nama_part = '".$namaPart."',
                    qty = '".$qty."',
                    diskon = '".$diskon."',
                    harga = '".$harga."'
                    WHERE nomor_pkb = '".$nopkb."'
                    AND kode_part = '".$kodePart."'";
                //~ var_dump($sqlUpdateVehicle);exit;

                $stmt = $conn->prepare($sqlUpdateVehicle);
                $stmt->execute();
            }
            catch (PDOException $e) {
                //~ var_dump($sqlUpdateVehicle);//exit;
                echo $e->getMessage();
                break;
            }
        }
    }

    $i++;
}

echo $i;
