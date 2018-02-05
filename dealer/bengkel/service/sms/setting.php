<?php
if (isset($_GET['op'])){
if ($_GET['op'] == 'simpan'){
	$id = str_replace(" ","-",$_POST['id']);
	$smsdrc = $_POST['smsdrc'];
	$port = strtolower(str_replace(" ","", $_POST['port']));
	$connection = strtolower(str_replace(" ","", $_POST['connection']));
	$send = 'yes';
	$receive = 'yes';
	$path = str_replace('setting.php', '', $_SERVER['SCRIPT_FILENAME']);
	$handle = @fopen($smsdrc, "w");
	$text = "[gammu]
# isikan no port di bawah ini
port = ".$port.":
# isikan jenis connection di bawah ini
connection = ".$connection."

[smsd]
service = mysql
logfile = ".$path."log".$smsdrc."
debuglevel = 0
phoneid = ".$id."
commtimeout = 30
sendtimeout = 600
send = ".$send."
receive = ".$receive."
checksecurity = 0
#PIN = 1234

# -----------------------------
# Konfigurasi koneksi ke MySQL
# -----------------------------
pc = localhost

# isikan user untuk akses ke MySQL
user = ".$dbuser."
# isikan password user untuk akses ke MySQL
password = ".$dbpass."
# isikan nama database untuk Gammu
database = ".$dbname."\n";

  fwrite($handle, $text);
  fclose($handle);
  
	$string = "";
	$j = 0;
	for($i=1; $i<=$maxmodem; $i++){
		if (is_file('smsdrc'.$i)){
			$handle = @fopen("smsdrc".$i, "r");
			if ($handle) {
				while (!feof($handle)) {
					$buffer = fgets($handle);
					if (substr_count($buffer, 'port = ') > 0){
						$split = explode("port = ", $buffer);
						$port = $split[1];
					}
					if (substr_count($buffer, 'connection = ') > 0){
						$split = explode("connection = ", $buffer);
						$connection = $split[1];
				}
				}
			}		
			fclose($handle);
			if ($j==0) $string .= "[gammu]\nport = ".$port."connection = ".$connection."\n";
			else $string .= "[gammu".($j)."]\nport = ".$port."connection = ".$connection."\n";
			$j++;
		}	
	}
	$handle = @fopen("gammurc", "w");
	fwrite($handle, $string);
	fclose($handle);
}
}

if (isset($_GET['op'])){
if ($_GET['op'] == 'del'){
	$id = $_GET['id'];
	if(is_file("logsmsdrc".$id)) unlink("logsmsdrc".$id);
	exec("gammu-smsd -n ".getParam('id', $id)." -k", $hasil);
	exec("gammu-smsd -n ".getParam('id', $id)." -u", $hasil);
	unlink("smsdrc".$id);
	
	$string = "";
	$j = 0;
	for($i=1; $i<=$maxmodem; $i++){
		if (is_file('smsdrc'.$i)){
			$handle = @fopen("smsdrc".$i, "r");
			if ($handle) {
				while (!feof($handle)) {
					$buffer = fgets($handle);
					if (substr_count($buffer, 'port = ') > 0){
						$split = explode("port = ", $buffer);
						$port = $split[1];
					}
					if (substr_count($buffer, 'connection = ') > 0){
						$split = explode("connection = ", $buffer);
						$connection = $split[1];
					}
				}
			}		
			fclose($handle);
			if ($j==0) $string .= "[gammu]\nport = ".$port."connection = ".$connection."\n";
			else $string .= "[gammu".($j)."]\nport = ".$port."connection = ".$connection."\n";
			$j++;
		}	
	}
	$handle = @fopen("gammurc", "w");
	fwrite($handle, $string);
	fclose($handle);
	
}
}

for($i=1; $i<=$maxmodem; $i++){
	if (is_file('smsdrc'.$i)){
		$sum = $i + 1;
	}	
}

if ($_GET[act]=='tambah'){
if ($sum == 0) $sum = 1;
$nextsmsdrc = "smsdrc".$sum;
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Modem</h3>
                </div>
              <div class='box-body'>
              <form method='POST' class='form-horizontal' action='index.php?view=setting&op=simpan' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>ID Phone/Modem</th> <td><input type='text' class='form-control' name='id'> </td></tr>
                    <tr><th scope='row'>PORT</th>               <td><input type='text' class='form-control' name='port'></td></tr>
                    <tr><th scope='row'>CONNECTION</th>           <td><select class='form-control' name='connection'>
                    													<option>at115200</option>
                    													<option>at19200</option>
                    													<option>at9600</option>
                    													<option>at</option>
                    												</select></td></tr>
                     <input type='hidden' name='smsdrc' value='$nextsmsdrc'>
                  </tbody>
                  </table>
                </div>
              </div>
              		<div class='box-footer'>
                    <button type='submit' name='submit1' class='btn btn-info'>Tambahkan</button>
                    <a href='index.php?view=setting'><button class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
              </form>
            </div>";

}elseif ($_GET[act]==''){
$sum = 0;
for($i=1; $i<=$maxmodem; $i++){
	if (is_file('smsdrc'.$i)){
		$sum++;
	}	
}
echo "<div class='col-md-12'>
		<div class='box'>
        <div class='box-header'>
        <h3 class='box-title'>Semua Data Modem</h3>
        <a class='pull-right btn btn-primary btn-sm' href='index.php?view=setting&act=tambah'>Tambahkan Data</a>
        </div>
        <div class='box-body'>
		<table id='example' class='table table-bordered table-striped'>
		    <thead>
		        <tr>
		            <th style='width:40px'>No</th>
		            <th>ID Phone</th>
		            <th>Port</th>
		            <th>Connection</th>
		            <th width='230px'><center>Action</center></th>
		        </tr>
		    </thead>
		    <tbody>";
$count = 0;
for($i=1; $i<=$maxmodem; $i++){
	if (is_file('smsdrc'.$i)){
			$count++;
			$handle = @fopen("smsdrc".$i, "r");
			if ($handle) {
				while (!feof($handle)) {
					$buffer = fgets($handle);
					if (substr_count($buffer, 'port = ') > 0){
						$split = explode("port = ", $buffer);
						$port = $split[1];
					}
					if (substr_count($buffer, 'phoneid = ') > 0){
						$split = explode("phoneid = ", $buffer);
						$phone = $split[1];
					}
					if (substr_count($buffer, 'connection = ') > 0){
						$split = explode("connection = ", $buffer);
						$conn = $split[1];
					}
				}
			}
	
		echo "<tr>
				<td>".$i."</td>
				<td>".$phone."</td>
				<td>".$port."</td>
				<td>".$conn."</td>
				<td align='center'><a class='btn btn-info btn-sm' href='index.php?view=setting&op=cek&id=".$count."'>Koneksi</a> 
									<a class='btn btn-success btn-sm' href='index.php?view=setting&op=service&id=".$i."'>Service</a> 
									<a class='btn btn-danger btn-sm' href='index.php?view=setting&op=service&op=del&id=".$i."'><span class='glyphicon glyphicon-remove'></span></td></tr>";
		$sum++;
	}	
}
echo "</tbody></table></div></div>";

if (isset($_GET['op'])){
	if ($_GET['op'] == 'cek'){
		$id = ($_GET['id']-1);
		echo "<p><b>Status Koneksi Phone/Modem ".$_GET['id']."</b></p>";
		echo "<pre>";
	    passthru("gammu -s ".$id." -c gammurc identify", $hasil);
	    echo "</pre>";
	}
}

if (isset($_GET['op'])){
if ($_GET['op'] == 'service'){
	$id = $_GET['id'];
	echo "<p><b>Status Service Phone/Modem: ".getParam('id', $id)."</b></p>";
	echo "<pre>";
    exec("gammu-smsd -n ".getParam('id', $id)." -k", $hasil);
	exec("gammu-smsd -n ".getParam('id', $id)." -u", $hasil);
	passthru("gammu-smsd -c smsdrc".$id." -n ".getParam('id', $id)." -i");
	exec("sc config ".getParam('id', $id)." start= demand");
    echo "</pre>";
}
}

echo "</td></tr>";
echo "</table>";
}

?>