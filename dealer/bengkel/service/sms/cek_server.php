<?php
include "config/koneksi.php";
include "function.php";
cekinbox();
$url = "http://domain.sch.id/application/sms";
$kodeapi = "123456789";
// baca data XML SMS antrian 
$xml = simplexml_load_file($url."/sms_api.php?op=get&code=".$kodeapi);
foreach ($xml as $dataxml){
	$id = $dataxml->id;
	$nohp = $dataxml->nohp;
	$pesan = $dataxml->pesan;
	// data SMS yang dibaca, lalu dikirim melalui gammu
	sendsms($nohp, $pesan, '');
	// setelah SMS dikirim, data SMS dalam antrian yang ada di server hosting dihapus
	$xml2 = simplexml_load_file($url."/sms_api.php?op=del&id=".$id."&code=".$kodeapi);
}

?>