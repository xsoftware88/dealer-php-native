<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', 300000);
include '../../../conf/conf.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//$inputFileName = 'Book1.xls';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB 2013 - JULI 17 LENGKAP PARTS DAN BAHAN.xlsx';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB.xls';
$inputFileName = '../../../temp/upload/bengkel/excel/SSC.xls';

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
for ($row = 4; $row <= $highestRow; $row++) {
$rowData = $sheet->rangeToArray('D' . $row . ':F' . $row,
                                null, true, false);
//~ var_dump($rowData[0]);exit;
    $noka       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $batch      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));

    $sqlPkb = "SELECT *
    FROM ssc_ab
    WHERE noka ='".$noka."'";

    $stmt = $conn->prepare($sqlPkb);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
            $sql = "INSERT INTO ssc_ab
            (noka, batch)
            VALUES (
            '".$noka."',
            '".$batch."')";
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
        //update
        try {
            $sql = "UPDATE ssc_ab
                SET
                noka='".$noka."',
                batch='".$batch."'
                WHERE noka = '".$noka."'";
            $conn->exec($sql);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            break;
        }
    }
    $i++;
}

echo $i;
