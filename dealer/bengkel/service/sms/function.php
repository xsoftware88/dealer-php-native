<?php
function getParam($x, $i){
	$handle = @fopen("smsdrc".$i, "r");
	if ($handle) {
		while (!feof($handle)) {
			$buffer = fgets($handle);
			if (substr_count($buffer, $x.' = ') > 0){
				$split = explode($x." = ", $buffer);
				$param = str_replace(chr(13).chr(10), "", $split[1]);
			}
		}
	}		
	fclose($handle);
	return $param;
}

function sendsms($nohp, $pesan, $modem){
	$pesan = str_replace("'", "\'", $pesan);
	if (strlen($pesan)<=160){ 
		$query = "INSERT INTO outbox (DestinationNumber, TextDecoded, SenderID, CreatorID) 
		          VALUES ('$nohp', '$pesan', '$modem', 'Gammu')";
		$hasil = mysql_query($query);
	}else{
		$jmlSMS = ceil(strlen($pesan)/153);
		$pecah  = str_split($pesan, 153); 
		$query = "SHOW TABLE STATUS LIKE 'outbox'";
		$hasil = mysql_query($query);
		$data  = mysql_fetch_array($hasil);
		$newID = $data['Auto_increment'];
		$random = rand(1, 255);
		$headerUDH = sprintf("%02s", strtoupper(dechex($random)));
	
		for ($i=1; $i<=$jmlSMS; $i++){
			$udh = "050003".$headerUDH.sprintf("%02s", $jmlSMS).sprintf("%02s", $i);
			$msg = $pecah[$i-1];
	  
			if ($i == 1) {	
				$query = "INSERT INTO outbox (DestinationNumber, UDH, TextDecoded, ID, MultiPart, SenderID, CreatorID)
						  VALUES ('$nohp', '$udh', '$msg', '$newID', 'true', '$modem', 'Gammu')";	  	  
			}						 
			else $query = "INSERT INTO outbox_multipart(UDH, TextDecoded, ID, SequencePosition)
						   VALUES ('$udh', '$msg', '$newID', '$i')";					  
			mysql_query($query); 	  
		}
   }
   return 'SMS sedang dikirim...';
}

function sendtoserver($text, $notelp, $timee, $idmodem){
	$url = "http://domain.sch.id/application/sms";
	$apicode = "123456789";
	$xml2 = simplexml_load_file($url."/save_to_web.php?op=send&pesan=".$text."&notelp=".$notelp."&timee=".$timee."&idmodem=".$idmodem."&code=".$apicode);
}

function cekinbox(){
	$query = "SELECT * FROM inbox WHERE (UDH = '' OR UDH LIKE '%01') AND processed = 'false'";
	$hasil = mysql_query($query);
	while ($data = mysql_fetch_array($hasil)){
		$sum = 0;
		$noTelp = $data['SenderNumber'];
		$idmodem = $data['RecipientID'];
   
		if ($data['UDH'] != ''){
			$chop = substr($data['UDH'], 0, 8);
			$n = (int) substr($data['UDH'], 8, 2);
			$text = "";
			for ($i=1; $i<=$n; $i++){
				$udh = $chop.sprintf("%02s", $n).sprintf("%02s", $i);
				$query3 = "SELECT * FROM inbox WHERE udh = '$udh' AND SenderNumber = '$noTelp' AND processed = 'false'";
				$hasil3 = mysql_query($query3);
				if (mysql_num_rows($hasil3) > 0) $sum++;
			}
	  
			if ($sum == $n){
				for ($i=1; $i<=$n; $i++){
					$udh = $chop.sprintf("%02s", $n).sprintf("%02s", $i);
					$query3 = "SELECT * FROM inbox WHERE udh = '$udh' AND SenderNumber = '$noTelp' AND processed = 'false'";
					$hasil3 = mysql_query($query3);
					$data3 = mysql_fetch_array($hasil3);
					$text .= $data3['TextDecoded'];
					$id = $data3['ID'];
					$query3 = "DELETE FROM inbox WHERE ID = '$id'";
					mysql_query($query3);
				}
	 
				$notelp = $data['SenderNumber'];
				$timee = $data['ReceivingDateTime'];
				$text = str_replace("'", "\'", $text);		  
			}	  
		}else{
			$id = $data['ID'];
			$notelp = $data['SenderNumber'];
			$timee = $data['ReceivingDateTime'];	  
			$text = str_replace("'", "\'", $data['TextDecoded']);
			$query2 = "DELETE FROM inbox WHERE ID = '$id'";
			mysql_query($query2);
		}
		
		// mengirim data sms ke server hosting
		sendtoserver($text, $notelp, $timee, $idmodem);
		$query2 = "INSERT INTO sms_inbox(pesan, nohp, waktu, modem) VALUES ('$text', '$notelp', '$timee', '$idmodem')";
		mysql_query($query2);
	}
}
?>