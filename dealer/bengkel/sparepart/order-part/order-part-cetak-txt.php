<?php
/*header('Pragma: anytextexeptno-cache', true);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: text/plain");
header('Content-Disposition: attachment; filename="part.txt"');
readfile('C:\\xampp\\htdocs\\bengkel\\temp\\text/order-part-tam.txt');
*/
//C:\xampp\htdocs\bengkel\bengkel\order-part\tmp
$order = '/var/www/html/dealer/bengkel/sparepart/order-part/tmp/order-part-tam.txt';
echo "<script>window.open($order, '_blank'); window.focus();</script>";
//header('location: index.php');
echo 'jika proses download file text tidak berjalan :
<a href="http://192.168.0.2/dealer/bengkel/sparepart/order-part/tmp/order-part-tam.txt"> CLICK SAYA </a> <br />';
echo 'kembali ke halaman upload. <a href="http://192.168.0.2/dealer/bengkel/sparepart/order-part/index.php">Go back</a>';
