<?php
include '../../../conf/conf.php';

$eror       = false;
//~ $folder     = 'upload-files/';
$folder = 'C:\xampp\htdocs\bengkel\upload-files\excel';
//type file yang bisa diupload
$file_type  = array('xls','xlsx','csv');
//tukuran maximum file yang dapat diupload
$max_size   = 1000000; // 1MB

if(isset($_POST['upload']) && !empty($_FILES['data_upload']) && $_FILES['data_upload']['error'] == 0){
    //Mulai memorises data
    $file_name  = $_FILES['data_upload']['name'];
    $file_size  = $_FILES['data_upload']['size'];
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
        if(move_uploaded_file($_FILES['data_upload']['tmp_name'], $folder.$file_name)){
            echo '<div id="msg">Berhasil mengupload file '.$file_name.'</div>';
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
    .'<input name="data_upload" type="file"> <br /><br />'
    .'<input name="upload" type="submit" value="Upload">'
    .'</form>';
