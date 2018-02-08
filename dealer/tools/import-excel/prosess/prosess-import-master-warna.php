<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', 300000);
include '../../conf/conf.php';

function cekTanggal($data) {
        $hasil = explode("-", $data);
        if( strlen($hasil[0]) == 2 ) {
        //echo "\"bar\" exists in the haystack variable";
        $data = $hasil[2].'-'.$hasil[1].'-'.$hasil[0];
        return $data;
        } else {
        $data = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data));
        return $data;
    }
}

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//$inputFileName = 'Book1.xls';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB 2013 - JULI 17 LENGKAP PARTS DAN BAHAN.xlsx';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB.xls';
$inputFileName = '../../temp/upload/sales/excel/MASTER-WARNA.xls';

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
$rowData = $sheet->rangeToArray('A' . $row . ':G' . $row,
                                null, true, false);
//~ var_dump($rowData[0]);exit;
    $katashiki       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $suffix          = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][1]));
    $katashikiSuffix = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));
    $clrCode         = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][3]));
    $model           = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][4]));
    $namaUnit        = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][5]));
    $warna           = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][6]));

    $sqlUnit = "SELECT *
    FROM master_unit_model_warna
    WHERE katashiki ='".$katashiki."'
    AND warna ='".$warna."'
    ORDER BY `master_unit_model_warna`.`katashiki` DESC limit 1";

    $stmt = $conn->prepare($sqlUnit);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
            $sql = "INSERT INTO master_unit_model_warna
                (`suffix`, `katashiki`, `katashiki_suffix`, `clr_code`, `model`, `nama_unit`, `warna`)
                VALUES (
                    '".$suffix."',
                    '".$katashiki."',
                    '".$katashikiSuffix."',
                    '".$clrCode."',
                    '".$model."',
                    '".$namaUnit."',
                    '".$warna."'
                )";
            //~ var_dump($sql);exit;

            $conn->exec($sql);
            $idMdb = $conn->lastInsertId();

            echo $i."  insert new ".$katashikiSuffix."<br />";
        }
        catch (PDOException $e) {
                echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }
    } else {
        try{
                 $sql = "UPDATE master_unit_model_warna
                        SET
                        `suffix` = '".$suffix."',
                        `katashiki` = '".$katashiki."',
                        `katashiki_suffix` = '".$katashikiSuffix."',
                        `clr_code` = '".$clrCode."',
                        `model` = '".$model."',
                        `nama_unit` = '".$namaUnit."',
                        `warna` = '".$warna."'
                        WHERE katashiki_suffix = '".$katashikiSuffix."'
                        AND warna ='".$warna."'";

                $conn->exec($sql);
        }
        catch (PDOException $e) {
                echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }

                echo $i."  update sama ".$katashikiSuffix."<br />";
    }
    $i++;
}

echo $i;
