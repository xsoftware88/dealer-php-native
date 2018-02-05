<?php
ini_set('memory_limit','-1');
ini_set('max_execution_time', 300000);
include '../../conf/conf.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//$inputFileName = 'Book1.xls';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB 2013 - JULI 17 LENGKAP PARTS DAN BAHAN.xlsx';
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB.xls';
$inputFileName = '../../temp/upload/bengkel/excel/BAST.xls';

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
$rowData = $sheet->rangeToArray('A' . $row . ':L' . $row,
                                null, true, false);
//~ var_dump($rowData[0]);exit;
    $noka       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][0]));
    $tglBast    = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][1]));
    $tglBbm     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][2]));
    $tipe       = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][3]));
    $warna      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][4]));

    $noSpk      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][6]));

    $namaCust   = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][7]));
	$namaCust   = str_replace("'", "", $namaCust);

    $namaStnk   = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][8]));
	$namaStnk   = str_replace("'", "", $namaStnk);

    $gesekan    = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][9]));

    $sales      = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][10]));
	$sales      = str_replace("'", "", $sales);

    $spv        = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][11]));
	$spv        = str_replace("'", "", $spv);

    $cabang     = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][12]));
    $jenisJual  = mysqli_real_escape_string($mysqli,strtoupper($rowData[0][14]));


    $tglBast      = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tglBast));
	$tglBbm       = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($tglBbm));

    $sqlPkb = "SELECT *
    FROM sales_unit_kirim
    WHERE noka ='".$noka."'
    ORDER BY `sales_unit_kirim`.`noka` DESC limit 1";

    $stmt = $conn->prepare($sqlPkb);
    $stmt->execute();
    $rowPkb  = $stmt->rowCount();
    $dataPkb = $stmt->fetchAll();

    if ($rowPkb == 0) {
        //data tidak ada, maka insert
        try {
			
			if ($jenisJual == 'CASH' || $jenisJual == 'TUNAI') {
				$sql = "INSERT INTO sales_unit_kirim
				(noka, tgl_bast, tgl_bbm, type_unit, warna_unit, nomor_spk, nama_cust, nama_stnk, gesekan, sales, spv, cabang, jenis_penjualan,approve_driver)
				VALUES (
				'".$noka."',
				'".$tglBast."',
				'".$tglBbm."',
				'".$tipe."',
				'".$warna."',
				'".$noSpk."',
				'".$namaCust."',
				'".$namaStnk."',
				'".$gesekan."',
				'".$sales."',
				'".$spv."',
				'".$cabang."',
				'".$jenisJual."',
				1)";
			} else {
				$sql = "INSERT INTO sales_unit_kirim
				(noka, tgl_bast, tgl_bbm, type_unit, warna_unit, nomor_spk, nama_cust, nama_stnk, gesekan, sales, spv, cabang, leasing, approve_driver)
				VALUES (
				'".$noka."',
				'".$tglBast."',
				'".$tglBbm."',
				'".$tipe."',
				'".$warna."',
				'".$noSpk."',
				'".$namaCust."',
				'".$namaStnk."',
				'".$gesekan."',
				'".$sales."',
				'".$spv."',
				'".$cabang."',
				'".$jenisJual."',
				1)";
			}
            //~ var_dump($sql);exit;
            $conn->exec($sql);
            $idVehicle = $conn->lastInsertId();

            echo $i."  insert new ".$noka."<br />";
        }
        catch (PDOException $e) {
        	echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }
    } else {
    	try{
		if ($jenisJual == 'CASH' || $jenisJual == 'TUNAI') {
			 $sql = "UPDATE sales_unit_kirim
				SET
				noka='".$nopkb."',
				tgl_bast='".$tglBast."',
				tgl_bbm='".$tglBbm."',
				type_unit='".$tipe."',
				warna_unit='".$warna."',
				nomor_spk='".$noSpk."',
				nama_cust='".$namaCust."',
				nama_stnk='".$namaStnk."',
				gesekan='".$gesekan."',
				sales='".$sales."',
				spv='".$spv."',
				cabang='".$cabang."',
				jenis_penjualan='".$jenisJual."',
				approve_driver=1
				WHERE noka = '".$noka."'";
		} else {
			 $sql = "UPDATE sales_unit_kirim
				SET
				noka='".$nopkb."',
				tgl_bast='".$tglBast."',
				tgl_bbm='".$tglBbm."',
				type_unit='".$tipe."',
				warna_unit='".$warna."',
				nomor_spk='".$noSpk."',
				nama_cust='".$namaCust."',
				nama_stnk='".$namaStnk."',
				gesekan='".$gesekan."',
				sales='".$sales."',
				spv='".$spv."',
				cabang='".$cabang."',
				jenis_penjualan='',
				leasing='".$jenisJual."',
				approve_driver=1
				WHERE noka = '".$noka."'";
		}
			
		$conn->exec($sql);
        }
        catch (PDOException $e) {
        	echo  $sql . '<br><br>';
            echo $e->getMessage();
            break;
        }

		echo $i."  update sama ".$noka."<br />";
    }
    $i++;
}

echo $i;
