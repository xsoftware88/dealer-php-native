<?php
include '../../../conf/conf.php';
//~ var_dump($dbname);exit;

$eror       = false;
//~ $folder     = 'upload-files/excel/';
$folder = '../../../temp/upload/bengkel/excel';
//~ $inputFileName = '../../../temp/upload/bengkel/excel/ORDERPART.xls';
//type file yang bisa diupload
$file_type  = array('xls','xlsx','csv');
//tukuran maximum file yang dapat diupload
$max_size   = 1000000; // 1MB

if(isset($_POST['upload']) && !empty($_FILES['dataUpload']) && $_FILES['dataUpload']['error'] == 0){
    //Mulai memorises data
    $file_name  = $_FILES['dataUpload']['name'];
    $file_size  = $_FILES['dataUpload']['size'];
    //cari extensi file dengan menggunakan fungsi explode
    $explode    = explode('.',$file_name);
    $extensi    = $explode[count($explode)-1];

    //check apakah type file sudah sesuai
    if(!in_array($extensi,$file_type)){
        $eror   = true;
        $pesan .= '- Type file yang anda upload tidak sesuai<br />';
    }
    if($file_size > $max_size){
        $eror   = true;
        $pesan .= '- Ukuran file melebihi batas maximum<br />';
    }
    //check ukuran file apakah sudah sesuai

    if($eror == true){
        echo '<div id="eror">'.$pesan.'</div>';
    }
    else{
        //mulai memproses upload file
        if(move_uploaded_file($_FILES['dataUpload']['tmp_name'], $folder.'/'.$file_name)){
            echo '<div id="msg">Berhasil mengupload file '.$file_name.'</div>';

            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();

            //$inputFileName = 'Book1.xls';
            //~ $inputFileName = $folder . '/laporan order spare parts (detail).xls';
            $inputFileName = $folder.'/'.$file_name;
            //~ var_dump($inputFileName);exit;

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

            $tmp1           = '';
            $tmp2           = '';
            $listData       = array();

            for ($row = 1; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('B' . $row . ':J' . $row,
                                            null, true, false);
//echo '<pre>';
                if ($row == 8) {
                  //var_dump($rowData);
                    $tmp1 = str_replace('INDRAPURA ','',$rowData[0][3]);
                    $nomerOrderCabang = substr($tmp1,2);
                }

                if ($row == 9) {
                  //var_dump($rowData);
                    $tglOrder =  PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][3], 'YYYYMMDD');
                }

                if ($row >= 12) {
                    if (is_null($rowData[0][0])) {
                        $conn = null;
                        // redirect prosess set tipe order
                        header('location: order-part-process-check.php');
                    }
//echo '<pre>';
//var_dump($rowData[0]);
                    $partNumber = str_replace('-','',$rowData[0][0]);
                    if (strlen($partNumber)<15) {
                        $cnt3 = strlen($partNumber);
                        $cnt3 = 15 - $cnt3;

                        for ($i = 0; $i < $cnt3; $i++) {
                            //~ $partNumber = $partNumber . '&nbsp;';
                            $partNumber = $partNumber . ' ';
                        }
                    }

                    $jmlPart = str_replace('-','',$rowData[0][2]);
                    if (strlen($jmlPart)<7) {
                        $cnt4 = strlen($jmlPart);
                        $cnt4 = 7 - $cnt4;
                        for ($i = 0; $i < $cnt4; $i++) {
                            //$jmlPart = '&nbsp;'.$jmlPart;
                            $jmlPart = ' '.$jmlPart;
                        }
                    }
//echo $partNumber;
                    $tmpData = 'O1501K' . $nomerOrderCabang . 'A' . $partNumber
                    . $jmlPart . $tglOrder
                    . '93';// . '<br />';

//var_dump($tmpData); exit;
                    try {
                        $sql = "INSERT INTO part_order_tam_temp (kode_order, cabang)
                        VALUES ('$tmpData', 'IDR')";

                        // use exec() because no results are returned
                        $conn->exec($sql);
                    }
                    catch (PDOException $e) {
                        echo $e->getMessage();
                        break;
                    }
                }

                //~ var_dump($rowData[0][3]);
                //~ if ($row == 12) { exit; }

            }
        } else{
            echo '<div id="eror">Proses upload eror</div>';
        }
    }
} else {
    $message = '<div id="eror">Check file anda</span>';
}

echo '<h1>Upload Data Order Part</h1>'
    .'<form method="post" enctype="multipart/form-data" action="">'
    .'Silakan Pilih File Excel: <br />'
    .'<input name="dataUpload" type="file"> <br /><br />'
    .'<input name="upload" type="submit" value="Upload">'
    .'</form>';
