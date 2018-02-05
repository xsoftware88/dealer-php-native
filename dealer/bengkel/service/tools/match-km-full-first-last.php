<?php
ini_set('memory_limit','-1');
include '../../../conf/conf.php';

//~ echo "<pre>";
$i = 0;
//~ $sql = "SELECT * FROM view_pkb_full_sebelumnya ORDER BY noka1, tanggal_pkb1 ASC";
$sql = "SELECT *
    FROM service_data_pkb_full
    WHERE tanggal_sebelumnya IS NULL
    OR tanggal_selanjutnya IS NULL
    ORDER BY tanggal_pkb ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rowData  = $stmt->rowCount();

var_dump(count($rowData));

if ($rowData != 0) {
    $data = $stmt->fetchAll();
    foreach ($data as $val) {
        if ((is_null($val['tanggal_sebelumnya'])
        || $val['tanggal_sebelumnya'] == "0000-00-00")
        &&(is_null($val['tanggal_selanjutnya'])
        || $val['tanggal_selanjutnya'] == "0000-00-00")) {
            // tanggal_sebelumnya tdk ada dan tanggal_selanjutnya tdk ada
            $tglAkhir      = $val['tanggal_pkb'];
            $kmAkhir       = $val['km'];

            $selisihHari   = ceil('180');
            $kmPerhari     = 56;

            $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAkhir)));

            $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAkhir)));

            $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
            $kmSebelumnya  = (int)$kmAkhir - $kmEstimasi;

            $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
            $kmNext        = (int)$kmAkhir + $kmEstimasi;

            $sql = "UPDATE service_data_pkb_full
                SET
                tanggal_sebelumnya='".$tglSebelumnya."',
                km_sebelumnya='".$kmSebelumnya."',
                tanggal_selanjutnya='".$tglNext."',
                km_selanjutnya='".$kmNext."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE service_data_pkb_last
                SET
                tanggal_sebelumnya='".$tglSebelumnya."',
                km_sebelumnya='".$kmSebelumnya."',
                tanggal_selanjutnya='".$tglNext."',
                km_selanjutnya='".$kmNext."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else if ((is_null($val['tanggal_sebelumnya'])
            || $val['tanggal_sebelumnya'] == "0000-00-00")
            && !is_null($val['tanggal_selanjutnya'])) {
                //awal krn tanggal_sebelumnya tdk ada
                $tanggalAwal  = $val['tanggal_pkb'];
                $tanggalAKhir = $val['tanggal_selanjutnya'];
                $tanggalPkb   = $val['tanggal_pkb'];
                $kmAwal       = $val['km'];
                $kmAkhir      = $val['km_selanjutnya'];

            if ($tanggalAwal == $tanggalPkb && $kmAwal > 1000 && $kmAwal < 10000) {
                $selisihHari   = ceil('30');
                $kmPerhari     = 333.333;

                $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tanggalAwal)));

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmSebelumnya  = (int)$kmAwal - $kmEstimasi;
            } else if ((int)$kmAwal > (int)$kmAkhir) {
                $selisihHari   = ceil('180');
                $kmPerhari     = 56;

                $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tanggalAwal)));

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmSebelumnya  = (int)$kmAwal - $kmEstimasi;
            } else {
                $tglAwal       = new DateTime($tanggalAwal);
                $tglAkhir      = new DateTime($tanggalAKhir);
                $diff          = date_diff( $tglAwal, $tglAkhir );
                $selisihHari   = (int)$diff->days;

                $selisihKm     = (int)$kmAkhir - $kmAwal;
                $kmPerhari     = (int)$selisihKm / $selisihHari;

                $tglSebelumnya = date('Y-m-d', strtotime('-'.$selisihHari.' days', strtotime($tglAwal->format("Y-m-d"))));

                $diff          = date_diff( $tglAkhir, new DateTime($tglSebelumnya ));
                $selisihHari   = (int)$diff->days;

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmSebelumnya  = (int)$kmAwal - $kmEstimasi;
            }

            $sql = "UPDATE service_data_pkb_full
                SET
                tanggal_sebelumnya='".$tglSebelumnya."',
                km_sebelumnya='".$kmSebelumnya."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE service_data_pkb_last
                SET
                tanggal_sebelumnya='".$tglSebelumnya."',
                km_sebelumnya='".$kmSebelumnya."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

        } else if (!is_null($val['tanggal_sebelumnya'])
            && (is_null($val['tanggal_selanjutnya'])
            || $val['tanggal_selanjutnya'] == "0000-00-00")) {
                //akhir krn tanggal_selanjutnya tdk ada
                $tanggalAwal  = $val['tanggal_sebelumnya'];
                $tanggalAKhir = $val['tanggal_pkb'];
                $tanggalPkb   = $val['tanggal_pkb'];
                $kmAwal       = $val['km_sebelumnya'];
                $kmAkhir      = $val['km'];

            if ($tanggalAwal == $tanggalPkb && $kmAwal > 1000 && $kmAwal < 10000) {
                $selisihHari   = ceil('30');
                $kmPerhari     = 333.333;

                $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tanggalAKhir)));

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmNext        = (int)$kmAkhir + $kmEstimasi;
            } else if ((int)$kmAwal > (int)$kmAkhir) {
                $selisihHari   = ceil('180');
                $kmPerhari     = 56;

                $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tanggalAKhir)));

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmNext        = (int)$kmAkhir + $kmEstimasi;
            } else {
                $tglAwal       = new DateTime($tanggalAwal);
                $tglAkhir      = new DateTime($tanggalAKhir);
                $diff          = date_diff( $tglAwal, $tglAkhir );
                $selisihHari   = (int)$diff->days;

                $selisihKm     = (int)$kmAkhir - $kmAwal;
                $kmPerhari     = (int)$selisihKm / $selisihHari;

                $tglNext       = date('Y-m-d', strtotime('+'.$selisihHari.' days', strtotime($tglAkhir->format("Y-m-d"))));

                $diff          = date_diff( $tglAkhir, new DateTime($tglNext ));
                $selisihHari   = (int)$diff->days;

                $kmEstimasi    = ceil((int)$kmPerhari) * ceil($selisihHari);
                $kmNext        = (int)$kmAkhir + $kmEstimasi;
            }

            $sql = "UPDATE service_data_pkb_full
                SET
                tanggal_selanjutnya='".$tglNext."',
                km_selanjutnya='".$kmNext."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE service_data_pkb_last
                SET
                tanggal_selanjutnya='".$tglNext."',
                km_selanjutnya='".$kmNext."'
                WHERE nomor_pkb = '".$val['nomor_pkb']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        $i++;
    }
}
echo $i;
