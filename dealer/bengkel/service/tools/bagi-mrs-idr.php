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

echo "<pre> ";//exit;
for ($row = 2; $row <= $highestRow; $row++) {
$rowData = $sheet->rangeToArray('B' . $row . ':D' . $row,
                                null, true, false);

    $nopkb      = mysql_real_escape_string(strtoupper($rowData[0][0]));
    $noka       = mysql_real_escape_string(strtoupper($rowData[0][1]));
    $sa         = mysql_real_escape_string(strtoupper($rowData[0][2]));

    //~ var_dump($rowData);exit;
    //cek no pkb
    $sqlVehicleHistorySelect = "SELECT `id`,`nomor_pkb` FROM `service_data_pkb_last`
    WHERE nomor_pkb = '".$nopkb."'";
    $stmt = $conn->prepare($sqlVehicleHistorySelect);
    $stmt->execute();
    $rowVehicleHistorySelect = $stmt->rowCount();

    if ($rowVehicleHistorySelect != 0) {
        //insert
        try {
            $sqlUpdateVehicle = "UPDATE service_data_pkb_last
                SET
                sa = '".$sa."'
                WHERE nomor_pkb = '".$nopkb."'
                AND noka = '".$noka."'";
            //~ var_dump($sqlUpdateVehicle);exit;

            $stmt = $conn->prepare($sqlUpdateVehicle);
            $stmt->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }

    $i++;
}

echo $i;
