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
$inputFileName = '../../temp/upload/bengkel/excel/MDB.xls';

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
$rowData = $sheet->rangeToArray('A' . $row . ':R' . $row,
                                null, true, false);
//~ var_dump($rowData[0]);exit;
    $rrn        	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $modelCode  	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][1]));
    $suffix     	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));
    $modelName  	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][3]));
    $colorCode  	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][4]));
    $colorName  	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][5]));

    $noka       	= mysqli_real_escape_string($mysqli,strtoupper($rowData[0][6]));
	$productionDate = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][7]));
	$engineNo       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][8]));

    $enginePc       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][9]));
	$pdiDate        = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][10]));

    $doDate         = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][11]));

    $dealer         = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][12]));
	$area           = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][13]));

    $branch         = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][14]));
	$destination    = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][15]));

    $assignFlag     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][16]));
    $endDestination = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][17]));

    $productionDate = cekTanggal($productionDate);
    $pdiDate        = cekTanggal($pdiDate);
	$doDate         = cekTanggal($doDate);

    $sqlUnit = "SELECT *
    FROM unit_stok
    WHERE rrn ='".$rrn."'
    ORDER BY `unit_stok`.`rrn` DESC limit 1";

    $stmt = $conn->prepare($sqlUnit);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
			$sql = "INSERT INTO unit_stok
			(`rrn`, `kode_model`, `suffix`, `nama_unit`, `kode_warna`, `warna`, `noka`, `produksi_date`, `nosin`, `nosin_prefix`, `pdi_date`, `tanggal_do`, `dealer`, `area`, `branch`, `destination`, `assign_flag`, `end_destination`)
			VALUES (
			'".$rrn."',
			'".$modelCode."',
			'".$suffix."',
			'".$modelName."',
			'".$colorCode."',
			'".$colorName."',
			'".$noka."',
			'".$productionDate."',
			'".$engineNo."',
			'".$enginePc."',
			'".$pdiDate."',
			'".$doDate."',
			'".$dealer."',
			'".$area."',
			'".$branch."',
			'".$destination."',
			'".$assignFlag."',
			'".$endDestination."'
			)";
            //~ var_dump($sql);exit;
            
            $conn->exec($sql);
            $idMdb = $conn->lastInsertId();

            echo $i."  insert new ".$rrn."<br />";
        }
        catch (PDOException $e) {
        	echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }
    } else {
    	try{
		 $sql = "UPDATE unit_stok
			SET
			`rrn` = '".$rrn."',
			`kode_model` = '".$modelCode."',
			`suffix` = '".$suffix."',
			`nama_unit` = '".$modelName."',
			`kode_warna` = '".$colorCode."',
			`warna` = '".$colorName."',
			`noka` = '".$noka."',
			`produksi_date` = '".$productionDate."',
			`nosin` = '".$engineNo."',
			`nosin_prefix` = '".$enginePc."',
			`pdi_date` = '".$pdiDate."',
			`tanggal_do` = '".$doDate."',
			`dealer` = '".$dealer."',
			`area` = '".$area."',
			`branch` = '".$branch."',
			`destination` = '".$destination."',
			`assign_flag` = '".$assignFlag."',
			`end_destination` = '".$endDestination."'
			WHERE rrn = '".$rrn."'";
			
		$conn->exec($sql);
        }
        catch (PDOException $e) {
        	echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }

		echo $i."  update sama ".$rrn."<br />";
    }
    $i++;
}

echo $i;
