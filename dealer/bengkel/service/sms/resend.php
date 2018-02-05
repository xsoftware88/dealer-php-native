<?php

ini_set('memory_limit', '-1');

include '../../../conf/conf.php';
echo '<pre>';


$sqlOutbox = "SELECT *
    FROM `outbox` ORDER BY UpdatedInDB";// DESC LIMIT 1";
//~ echo $sqlRemminderWithCount;exit;

$stmt = $conn->prepare($sqlOutbox);
$stmt->execute();
$rowOutbox  = $stmt->rowCount();


if ($rowOutbox != 0) {
    $dataOutbox = $stmt->fetchAll();
    foreach ($dataOutbox as $keyOutbox => $valOutbox)
    {
        $phone = preg_replace("/[^0-9,.-]/", "", $valOutbox['DestinationNumber'] );
        $phone = str_replace('-','',$phone);

        $firstString = substr($phone,0,1);
        if ($firstString != 0) {
            $phone = '0'.$phone;
        }

        var_dump($valOutbox['ID']);
        //echo $phone;
        echo'<br>';


        $sqlHapusOutbox = "DELETE FROM outbox where DestinationNumber='".$valOutbox['DestinationNumber']."'";
        $stmt = $conn->prepare($sqlHapusOutbox);
        $stmt->execute();

        $kirimUlang  = "INSERT INTO outbox
                        (DestinationNumber, SenderID, TextDecoded, CreatorID)
                    VALUES  (
                        '".$valOutbox['DestinationNumber']."',
                        '',
                        '".$valOutbox['TextDecoded']."',
                        '".$valOutbox['CreatorID']."'
                    )";

        //~ var_dump($hasil);exit;
        $conn->exec($kirimUlang);//*/
    }
}//*/


/*$time = time();
while ( true ) {
    /*
     * Play Some Ball
     */

    /*if ((time() - $time) >= 8) {
        echo date("Y:m:d g:i:s"), PHP_EOL;
        $time = time();
        //exit;
    }
    sleep(2);
}*/
