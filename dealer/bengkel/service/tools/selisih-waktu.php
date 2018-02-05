<?php

$awal  = new DateTime('2017-10-23 20:00:00');
$akhir = new DateTime('2017-10-24 21:00:00'); // waktu sekarang
//~ $akhir = new DateTime(); // waktu sekarang
$diff  = date_diff( $awal, $akhir );

echo '<br />waktu awal : '. $awal->format("Y-m-d H:i:s");
echo '<br />waktu akhir : '. $akhir->format("Y-m-d H:i:s");

echo '<br />Selisih waktu: <br />';
echo $diff->y . ' tahun, <br />';
echo $diff->m . ' bulan, <br />';
echo $diff->d . ' hari, <br />';
echo $diff->h . ' jam, <br />';
echo $diff->i . ' menit, <br />';
echo $diff->s . ' detik, <br />';
// Output: Selisih waktu: 28 tahun, 5 bulan, 9 hari, 13 jam, 7 menit, 7 detik

echo '<br /> Total selisih hari : ' . $diff->days;
// Output: Total selisih hari: 10398
$awal  = strtotime($awal->format("Y-m-d H:i:s"));
$akhir = strtotime($akhir->format("Y-m-d H:i:s"));

$awal   = date('Y-m-d H:i:s',strtotime('+15 minute',$awal));;
$akhir  = date('Y-m-d H:i:s',strtotime('-15 minute',$akhir));;

$awal  = strtotime($awal);
$awal  = $awal + 15;
$akhir = strtotime($akhir);
$akhir  = $akhir + 15;

$interval  = abs($akhir - $awal);
echo "<br>====<br>".$interval."<br>====<br>";
$minutes   = round($interval / 60);
echo '<br /> Diff. in minutes is: '.$minutes;
        $minutes  = $minutes - 5;

$total   = date('Y-m-d H:i:s',strtotime('+'.$minutes.' minute',$awal));
echo '<br /> total waktu: '.$total;
