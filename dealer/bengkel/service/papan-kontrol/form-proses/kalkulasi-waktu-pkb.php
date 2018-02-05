<?php

$startTime  = $_POST['datang'];

// target peneriman an SA paling lama
$maxTimeSa  = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($startTime)));
//$maxTimePkb = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($startTime)));

if (isset($_POST['penyerahan'])) {
    $EndTime    = $_POST['penyerahan'];
    $mulai   = strtotime($startTime);
    $selesai = strtotime($EndTime);
    if ($mulai >= $selesai) {
        $maxTimePkb = date('Y-m-d H:i:s',strtotime('1 day',strtotime($startTime)));
    } else {
        $maxTimePkb =  $EndTime;
    }
} else {
    $maxTimePkb = date('Y-m-d H:i:s',strtotime('1 day',strtotime($startTime)));
}
//~ $maxTimePkb  = date('Y-m-d H:i:s',strtotime('-10 minute',strtotime($_POST['penyerahan'])));

$maxTimeForman  = '+5 minute';
$maxTimeForman  = date('Y-m-d H:i:s',strtotime($maxTimeForman, strtotime($maxTimeSa)));

if (isset($_POST['tipeOrder'])) {
    if ($_POST['tipeOrder'] == 'sbi') {

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+15 minute', strtotime($maxTimeForman)));

    } else if ($_POST['tipeOrder'] == 'sbe 10k'
    || $_POST['tipeOrder'] == 'sbe 30k'
    || $_POST['tipeOrder'] == 'sbe 50k') {

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+60 minute', strtotime($maxTimeForman)));

    } else if ($_POST['tipeOrder'] == 'sbe 20k'
    || $_POST['tipeOrder'] == 'sbe 40k'
    || $_POST['tipeOrder'] == 'sbe other') {

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+75 minute',strtotime($maxTimeForman)));

    } else if ($_POST['tipeOrder'] == 'twc'
    || $_POST['tipeOrder'] == 'engine tuneup'
    || $_POST['tipeOrder'] == 'return') {

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+45 minute',strtotime($maxTimeForman)));

    } else if ($_POST['tipeOrder'] == 'grr ringan') {

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+15 minute',strtotime($maxTimeForman)));

    } else if ($_POST['tipeOrder'] == 'grr berat') {
        $awal  = strtotime($maxTimeForman);
        $akhir = strtotime($maxTimePkb);

        $interval = abs($akhir - $awal);
        $minutes  = round($interval / 60);
        $minutes  = $minutes - 5;

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+'.$minutes.' minute',$awal));

    } else {
        $awal     = strtotime($maxTimeForman);
        $akhir    = strtotime($maxTimePkb);

        $interval = abs($akhir - $awal);
        $minutes  = round($interval / 60);
        $minutes  = $minutes - 5;

        $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+'.$minutes.' minute',$awal));
    }
} else {
    $awal     = strtotime($maxTimeForman);
    $akhir    = strtotime($maxTimePkb);

    $interval = abs($akhir - $awal);
    $minutes  = round($interval / 60);
    $minutes  = $minutes - 5;

    $maxTimeTeknisi = date('Y-m-d H:i:s',strtotime('+'.$minutes.' minute',$awal));
}

//~ var_dump($awal);
//~ var_dump($akhir);
//~ var_dump($interval);
//~ var_dump($minutes);

if (isset($_POST['opl']) && isset($_POST['tipeOrder'])) {
    if ($_POST['opl'] == 'sporing balancing' || $_POST['opl'] == 'sporing') {

        $maxTimeOpl = date('Y-m-d H:i:s',strtotime('+30 minute',strtotime($maxTimeTeknisi)));

    } else if ($_POST['opl'] == 'ac') {

        $maxTimeOpl = date('Y-m-d H:i:s',strtotime('+120 minute',strtotime($maxTimeTeknisi)));

    } else if ($_POST['opl'] == 'other') {

        $maxTimeOpl = date('Y-m-d H:i:s',strtotime('+1440 minute',strtotime($maxTimeTeknisi)));

    } else if ($_POST['opl'] == 'balancing' || $_POST['opl'] == 'non opl') {

        $maxTimeOpl = $maxTimeTeknisi;

    } else {

        $maxTimeOpl = null;

    }
} else {

    $maxTimeOpl = null;

}

if (isset($_POST['servicePlus']) && isset($_POST['opl']) && isset($_POST['tipeOrder'])) {
    if ((!is_null($maxTimeOpl) && $_POST['servicePlus'] == 'wetlook')
    || (!is_null($maxTimeOpl) && $_POST['servicePlus'] == 'cuci')) {

        $maxTimeWashing = date('Y-m-d H:i:s',strtotime('+10 minute',strtotime($maxTimeOpl)));

    }  else {

        $maxTimeWashing = null;

    }
}  else {

    $maxTimeWashing = null;

}


    /*if ($_POST['tipeOrder'] != 'sbi') {
        $maxTimeWashing = date('Y-m-d H:i:s',strtotime('+15 minute',strtotime($maxTimeTeknisi)));
        //~ $estimasiTimePkb = date('Y-m-d H:i:s',strtotime('+5 minute',$maxTimeWashing));
        $estimasiTimePkb = $maxTimeWashing;
    } else {
        $maxTimeWashing = date('Y-m-d H:i:s',strtotime('+5 minute',strtotime($maxTimeTeknisi)));
        //~ $estimasiTimePkb = date('Y-m-d H:i:s',strtotime('+5 minute',$maxTimeWashing));
        $estimasiTimePkb = $maxTimeWashing;
    }*/

echo 'Waktu awal : ' . $startTime;
echo '<br>';
echo 'Max Waktu Sa : ' . $maxTimeSa;
echo '<br>';
echo 'Max Waktu Forman : ' . $maxTimeForman;
echo '<br>';
echo 'Max Waktu Teknisi : ' . $maxTimeTeknisi;
echo '<br>';

if (isset($maxTimeOpl)) {
	if (!is_null($maxTimeOpl)) {
		echo '<br>';
		echo 'Max Waktu OPL : ' . $maxTimeOpl . '<br>';
	}
}

if (isset($maxTimeWashing)) {
	if (!is_null($maxTimeWashing)) {
		echo '<br>';
		echo 'Max Waktu Service Plus : ' . $maxTimeWashing . '<br>';
	}
}

echo '<br>';

if (isset($_POST['tipeOrder'])) {
    //if ($startTime >= $EndTime) {
    //}
    if ($_POST['tipeOrder'] == 'grr berat') {
        echo 'Karena waktu awal >= waktu akhir, <br>';
        echo 'maka waktu akhir akan dikalkulasi +1 hari <br>';
        echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimePkb;
        echo '<br>';
    } else {
        if (isset($_POST['servicePlus']) && isset($_POST['opl']) && isset($_POST['tipeOrder'])) {
            if ($_POST['servicePlus'] == 'wetlook' || $_POST['servicePlus'] == 'cuci') {
                		
				$maxTimeDelivery = date('Y-m-d H:i:s',strtotime('+5 minute',strtotime($maxTimeWashing)));
				echo '<br>';
				echo 'Max Waktu Serah Terima : ' . $maxTimeDelivery . '<br>';
                echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimeDelivery;
				
            } else {                	
				$maxTimeDelivery = date('Y-m-d H:i:s',strtotime('+5 minute',strtotime($maxTimeTeknisi)));
				echo '<br>';
				echo 'Max Waktu Serah Terima : ' . $maxTimeDelivery . '<br>';
				
                echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimeDelivery;	
            }
        } else {
			if (isset($maxTimeOpl)) {
				if (!is_null($maxTimeOpl)) {              	
					$maxTimeDelivery = date('Y-m-d H:i:s',strtotime('+5 minute',strtotime($maxTimeOpl)));
					echo '<br>';
					echo 'Max Waktu Serah Terima : ' . $maxTimeDelivery . '<br>';
					
					echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimeDelivery;	
				}
			} else {         	
				$maxTimeDelivery = date('Y-m-d H:i:s',strtotime('+5 minute',strtotime($maxTimeTeknisi)));
				echo '<br>';
				echo 'Max Waktu Serah Terima : ' . $maxTimeDelivery . '<br>';
					
				echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimeDelivery;
			}
        }
    }
} else {
    echo 'Karena waktu awal >= waktu akhir, <br>';
    echo 'maka waktu akhir akan dikalkulasi +1 hari <br>';
    echo '<b>Estimasi Akhir PKB</b> : ' . $maxTimePkb;
    echo '<br>';
}




//~ var_dump($maxTimePkb );
//~ var_dump($maxTimeTeknisi );
//~ exit;
