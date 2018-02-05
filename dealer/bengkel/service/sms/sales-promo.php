<?php
ini_set('memory_limit', '-1');

include '../../../conf/conf.php';

$i = 1;
$x = 1;
//$batasTgl = date('Y-m-d 00:00:00', strtotime("-3 week"));
$batasTgl = date('Y-m-d 00:00:00', strtotime("270 days"));
//var_dump($batasTgl);exit;

/*$sqlRemminderWithCount = "SELECT id,nopol,noka,phone,sa,tanggal_pkb
    FROM `service_data_pkb_last`
    WHERE 'tanggal_pkb' > '".$batasTgl."'
    ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";*/

$sqlRemminderWithCount = "SELECT id,nopol,noka,phone,sa,tanggal_pkb
    FROM `service_data_pkb_full`
    WHERE 'tanggal_pkb' > '2016-01-01' 
    AND `sa` LIKE '%idr%'
    GROUP BY noka
    ORDER BY `tanggal_pkb` ASC";

//~ echo $sqlRemminderWithCount;exit;

$stmt = $conn->prepare($sqlRemminderWithCount);
$stmt->execute();
$rowRwc  = $stmt->rowCount();

if ($rowRwc != 0) {
    $dataRwc = $stmt->fetchAll();
    foreach ($dataRwc as $valRwc) {
        $tglAwal  = new DateTime($valRwc['tanggal_pkb']);
        $tglAkhir = new DateTime();
        $diff     = date_diff( $tglAwal, $tglAkhir );
        $jmlHari  = (int)$diff->days;

        if ($jmlHari > 270) {
            // select reminder by noka
            $sql  = "SELECT *
                    FROM service_data_remminder
                    WHERE noka = '".$valRwc['noka']."'";
                    //AND sa = '".$sa."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $rowData  = $stmt->rowCount();

            if ($rowData != 0) {
                $data = $stmt->fetchAll();

                foreach ($data as $val) {
                    if ($val['tanggal_remminder'] < $batasTgl) {
                        $valRwc['sa_remminder']      = $val['sa'];
                        //~ $valRwc['sa_remminder']      = $valRwc['sa'];

                        $dataSiapRemainder['data'][] = $valRwc;
                    }
                }
            } else {
                $valRwc['sa_remminder']      = ' - ';

                $dataSiapRemainder['data'][] = $valRwc;
            }
            //~ var_dump($dataSiapRemainder['data']);exit;
        }
    }
}

// kurang data reminder yg null
if (isset($dataSiapRemainder['data'])
&& !empty($dataSiapRemainder['data'])) {
    $dataSiapRemainderByKm = $dataSiapRemainder['data'];
    $totalData = count($dataSiapRemainderByKm);
    //~ var_dump($dataSiapRemainder['data']);exit;
    foreach ($dataSiapRemainderByKm as $valHistory) {
        $phone = preg_replace("/[^0-9,.-]/", "", $valHistory['phone'] );
        /*echo $valHistory['nopol']."<br />"
            .$phone."<br />"
            .$valHistory['sa_remminder']
            ."<br />==================<br />";*/

        $nopol = $valHistory['nopol'];

        /*$kontenSms = 'GRATIS 2LITER Oli Mesin TMO senilai 175rb utk '
                        .$nopol. ' service berkala DES 2017 '
                        .'Booking skrng di LIEK MOTOR '
                        .'Tlp 031-3520123/ WA +6281231261937 '
                        .'Tunjukan SMS ini';*/
        $kontenSms = 'Event All New Rush Toyotaindrapura.com sabtu 20 Jan 2018,'
        			  .'Bunga 0% ,TV LED, dan dapatkan Free OLI 2lt.' 
                      .'Info lebih lanjut Hotline: 031-3538999 WA: 088803200611 ';


        //~ echo $kontenSms;exit;

        if ($valHistory['sa_remminder'] == ' - ') {

            //~ $m      = "SELECT ID FROM phones ORDER BY ID DESC LIMIT 1";
            //~ $stmt = $conn->prepare($m);
            //~ $stmt->execute();
            //~ $dataPhon = $stmt->fetchAll();

            $hasil  = "INSERT INTO outbox
                            (DestinationNumber, TextDecoded, CreatorID, Class)
                        VALUES (
                            '".$phone."',
                            '".$kontenSms."',
                            '".$valHistory['sa']."',
                            '0'
                        )";

            $conn->exec($hasil);

            /*$tmpData[] = array(
                    'phone' => $phone,
                    'nopol' => $valHistory['nopol'],
                    'noka'  => $valHistory['noka'],
                    'sa'    => $valHistory['sa']
                );*/
                //~ $i++;
                //~ $jml[$i] = $i;
        } else {

            //~ $m      = mysql_fetch_array(mysql_query("SELECT ID FROM phones ORDER BY ID DESC LIMIT 1"));

            $hasil  = "INSERT INTO outbox
                    (DestinationNumber, TextDecoded, CreatorID, Class)
                        VALUES (
                            '".$phone."',
                            '".$kontenSms."',
                            '".$valHistory['sa_remminder']."',
                            '0'
                        )";

            $conn->exec($hasil);

            /*$tmpData[] = array(
                    'phone' => $phone,
                    'nopol' => $valHistory['nopol'],
                    'noka'  => $valHistory['noka'],
                    'sa'    => $valHistory['sa_remminder']
                );*/
                //~ $x++;
                //~ $jml[$x] = $x;
        }
    }

//~ var_dump(count($jml[$i]));
//~ echo '<br>=======<br>';
//~ var_dump(count($jml[$x]));

    //var_dump($tmpData);
    /*@mysql_close($conn);
    /* Output header
    header('Content-type: application/json');
    echo json_encode($tmpData);*/

}
