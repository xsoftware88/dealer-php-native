<?php
session_start();
ob_start();

include __DIR__ . "/../../conf/conf.php";
define ("pdf_page_format", "A4");

$kode   = $_GET['kode']; 
  
  $statement = "SELECT * FROM sales_unit_kirim WHERE nomor_spk='".$kode."'";
  $stmt = $conn->prepare($statement);
  $stmt->execute();
  $result = $stmt->fetchAll();
  
  //echo'<pre>';
  //var_dump($result);exit;

$filename = dirname(__FILE__).'/../../temp/download/bast/'.$result[0]['nomor_spk'].".pdf"; 

$content = ob_get_clean();
$content = '<page style="font-family: freeserif">'.nl2br($content).'</page>';
 require_once(dirname(__FILE__).'/../../vendor/html2pdf/tcpdf.php');
 //require_once('tcpdf_include.php');

class PDF extends TCPDF
{
// Page header
	function Header()
	{
    	$host = "http://$_SERVER[HTTP_HOST]";
    
    	$this->setJPEGQuality(90);
		$this->Image($host.'/dealer/asset/img/header.png', 4, 0, 202, 0, 'PNG', $host);
	}
	public function Footer() {
    	//$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		//$this->Line(0, 0, 0, 0, $style);	
    	$this->SetLineStyle( array( 'width' => 0.5, 'color' => array(0, 0, 0) ) );
    	$this->Line( 9, 280, 200, 280 );
    	
    	//$this->Ln();
    
		$this->SetY(-15);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
		$this->Cell(0, 10, 'Lembar 1 : admin               Lembar 2 : Petugas Gudang & Scurity               Lembar 3 : Pelanggan', 0, false, 'C');
	}
	public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 14, $fontstyle = '', $align = 'L') {
		$this->SetXY($x+20, $y); // 20 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, false, $align);
	}
}


 try
 {
  	$html2pdf = new PDF('P', 'mm', 'A4');
  	$html2pdf->AddPage();
  	$html2pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  	$html2pdf->setPrintHeader(false);
 
 	// HEAD
 	$html2pdf->CreateTextBox('BUKTI SERAH TERIMA KENDARAAN', 10, 24, 80, 10, 14, 'B');
	$html2pdf->CreateTextBox('Nomor', 137, 24, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nomor_bast'], 157, 24, 80, 10, 11);
	$html2pdf->CreateTextBox('Tanggal', 137, 28, 80, 10, 11);
 	$html2pdf->CreateTextBox( date('d-m-Y', strtotime($result[0]['tgl_bast'])), 157, 28, 80, 10, 11);
 
 	//$html2pdf->CreateTextBox( date('Y-m-d'), 157, 28, 80, 10, 11);
 
 	//DATA SPK
 	$html2pdf->CreateTextBox('No Surat Pesanan', -12, 38, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nomor_spk'], 24, 38, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tgl Surat Pesanan', -12, 42, 80, 10, 11);
 	$html2pdf->CreateTextBox( date('d-m-Y', strtotime($result[0]['tgl_spk'])), 24, 42, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('No Pelanggan', -12, 46, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nomor_pelanggan'], 24, 46, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Jenis Penjualan', -12, 50, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['jenis_penjualan'], 24, 50, 80, 10, 11, 'B');
 
 	if (strtoupper($result[0]['jenis_penjualan']) != 'TUNAI') {
 		$html2pdf->CreateTextBox('Leasing ', -12, 54, 80, 10, 11);
 		$html2pdf->CreateTextBox($result[0]['leasing'], -12, 58, 80, 10, 11, 'B');
    }
 
 	//Data Customer
 	$html2pdf->CreateTextBox('Kepada', 80, 38, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nama_cust'], 80, 42, 80, 10, 10, 'B');
 	$html2pdf->CreateTextBox($result[0]['alamat_cust'], 80, 46, 80, 10, 10, 'B');
 	$html2pdf->CreateTextBox($result[0]['kecamatan_cust'] .', '. $result[0]['kota_cust'], 80, 50, 80, 10, 10, 'B');
 
 	$html2pdf->CreateTextBox('NPWP', 80, 58, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['npwp_cust'], 95, 58, 80, 10, 10, 'B');
 
 	//Data Unit
 	$html2pdf->CreateTextBox('Unit Mobil', -12, 66, 80, 10, 11);
 	//$html2pdf->CreateTextBox($result[0]['type_unit'], 24, 66, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tipe', -12, 70, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['type_unit'], 24, 70, 80, 10, 11, 'B');
  	$html2pdf->CreateTextBox('No Rangka', -12, 74, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['noka'], 24, 74, 80, 10, 11, 'B');
  	$html2pdf->CreateTextBox('No Mesin', -12, 78, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nosin'], 24, 78, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tahun', -12, 82, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['tahun_unit'], 24, 82, 80, 10, 11, 'B');
 
 	$html2pdf->CreateTextBox('Warna', 80, 66, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nama_cust'], 110, 66, 80, 10, 10, 'B');
 	$html2pdf->CreateTextBox('Nomor Polisi', 80, 70, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['nopol_unit'], 110, 70, 80, 10, 10, 'B');
  	$html2pdf->CreateTextBox('Gesekan', 80, 74, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['gesekan'], 110, 74, 80, 10, 10, 'B');
 
 
 	$html2pdf->CreateTextBox('Perlengkapan Tambahan', -12, 90, 80, 10, 10,'B');
 
 	$html2pdf->CreateTextBox('(   ) Kaca Spion Luar KA / KI', -12, 100, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Simbol Emblem', -12, 104, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Kaca FIlem', -12, 108, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Dongrak + Stang', -12, 112, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Kunci Roda', -12, 116, 10, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Obeng +/-', -12, 120, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Kunci Pas', -12, 124, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Tang', -12, 128, 80, 10, 11);
 	$html2pdf->CreateTextBox('(   ) Kunci Inggris', -12, 132, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Kunci Busi', -12, 136, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Cat Cadangan', -12, 140, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Ban Cadangan', -12, 144, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Penahan Sinar Matahari', -12, 148, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Kaca Spion Dalam', -12, 152, 80, 10, 11);
 
  
 	$html2pdf->CreateTextBox('(   ) Wypers & Fasher', 70, 100, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Karpet Cabine', 70, 104, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Karpet Karet', 70, 108, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Anak Kunci', 70, 112, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Wieldop', 70, 116, 10, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Manual / ServiceBook', 70, 120, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Tutup Tangki', 70, 124, 80, 10, 11);
   	$html2pdf->CreateTextBox('(   ) Cigarette Lighter', 70, 128, 80, 10, 11);
 	$html2pdf->CreateTextBox('(   ) Asbak Depan', 70, 132, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Asbak Belakang', 70, 136, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Radio / Tape', 70, 140, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Central Lock', 70, 144, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Power Window', 70, 148, 80, 10, 11);
  	$html2pdf->CreateTextBox('(   ) Alarm', 70, 152, 80, 10, 11);
 
 	// Tanda Terima
   	$html2pdf->CreateTextBox('Diserahkan Gudang', 138, 100, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tanggal', 138, 104, 80, 10, 11);
 
   	$html2pdf->CreateTextBox('Diterima Driver', 138, 130, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tanggal', 138, 134, 80, 10, 11);

   	$html2pdf->CreateTextBox('Diserahkan Pelanggan', 138, 160, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('Tanggal', 138, 164, 80, 10, 11);
 
   	$html2pdf->CreateTextBox('Mengetaui', 138, 190, 80, 10, 11, 'B');
 	$html2pdf->CreateTextBox('(Kepala Administrasi)', 138, 220, 80, 10, 11);
 
    $html2pdf->CreateTextBox($result[0]['sales'], -12, 262, 80, 10, 11);
 	$html2pdf->CreateTextBox($result[0]['spv'], -12, 266, 80, 10, 11);
 
  	$html2pdf->writeHTML($content);
  	$html2pdf->Output($filename, 'I');
  	$html2pdf->Output($filename, 'F');

 }
 catch(HTML2PDF_exception $e) { echo $e; }
?>