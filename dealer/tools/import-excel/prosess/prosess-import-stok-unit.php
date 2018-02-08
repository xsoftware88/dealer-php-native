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
$inputFileName = '../../temp/upload/sales/excel/STOK-UNIT.xls';

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
$rowData = $sheet->rangeToArray('A' . $row . ':B' . $row,
                                null, true, false);
//~ var_dump($rowData[0]);exit;
    $rrn                = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $noka               = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][1]));
    $nosin              = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));
    $tanggalDo          = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][3]));
    $posisi             = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][4]));

        $tanggalDo      = cekTanggal($tanggalDo);

    $sqlUnit = "SELECT *
    FROM unit_stok
    WHERE rrn = '".$rrn."'
    ORDER BY `unit_stok`.`rrn` DESC limit 1";

    $stmt = $conn->prepare($sqlUnit);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        echo 'noka '.$noka.' tidak ada <br>';
    } else {
        try{
                 $sql = "UPDATE unit_stok
                        SET
                        `rrn` = '".$rrn."',
                        `noka` = '".$noka."',
                        `nosin` = '".$nosin."',
                        `tanggal_do` = '".$tanggalDo."',
                        `posisi_unit` = '".$posisi."'
                        WHERE rrn = '".$rrn."'";

                $conn->exec($sql);
        }
        catch (PDOException $e) {
                echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }//*/

                echo $i."  update sama ".$noka."<br />";
    }
    $i++;
}

echo $i;
