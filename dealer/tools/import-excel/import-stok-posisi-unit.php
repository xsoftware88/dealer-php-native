<?php

error_reporting(E_ALL);

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('memory_limit', '-1');

date_default_timezone_set('Asia/Jakarta');

//define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$error      = false;
$pesan      = '';
//~ $folder     = 'upload-files/excel/';
$folder     = '../../temp/upload/bengkel/excel/';
//type file yang bisa diupload
$file_type  = array('xls','xlsx','csv','XLS','XLSX');
//tukuran maximum file yang dapat diupload
$max_size   = 100000000; // 1MB
//~ $inputFileName = 'C:\xampp\htdocs\bengkel\upload-files\excel/PKB';
$inputFileName = '../../temp/upload/bengkel/excel/STOK-POSISI-UNIT';

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
        //~ var_dump($_FILES);exit;
    if(isset($_FILES["data_upload"]) && $_FILES["data_upload"]["error"] == 0){
        //~ $filename = $_FILES["data_upload"]["name"];
        //~ $filetype = $_FILES["data_upload"]["type"];
        //~ $filesize = $_FILES["data_upload"]["size"];

        //Mulai memorises data
        $file_name  = $_FILES['data_upload']['name'];
        $file_size  = $_FILES['data_upload']['size'];
        //cari extensi file dengan menggunakan fungsi explode
        $explode    = explode('.',$file_name);
        $extensi    = $explode[count($explode)-1];

        //check apakah type file sudah sesuai
        if(!in_array($extensi,$file_type)){
            $error   = true;
            $pesan .= '- Type file yang anda upload tidak sesuai<br />';
        }
        //check ukuran file apakah sudah sesuai
        if($file_size > $max_size){
            $error   = true;
            $pesan .= '- Ukuran file melebihi batas maximum<br />';
        }

        if($error == true){
            echo '<div id="eror">'.$pesan.'</div>';
        } else{
            //mulai memproses upload file
            if(move_uploaded_file($_FILES['data_upload']['tmp_name'], $inputFileName.'.xls')){//.$extensi)){
                echo '<div id="success">Berhasil mengupload file '.$inputFileName.'.'.$extensi
                .'<br /><a href="prosess-import-stok-posisi-unit.php">PROSES HASIL UPLOAD</a></div>';
            } else{
                echo '<div id="error">Proses upload eror</div>';
            }
        }
    }
} else {
    echo '<h1>Upload EXCEL STOK POSISI UNIT</h1>'
        .'<form method="post" enctype="multipart/form-data" action="">'
        .'Silakan Pilih File Excel: <br />'
        .'<input name="data_upload" type="file"> <br /><br />'
        .'<input name="upload" type="submit" value="Upload">'
        .'</form>';
}