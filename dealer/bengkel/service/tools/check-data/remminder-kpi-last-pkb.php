<?php

        if ($keySa == 'MRSIDR1' || $keySa == 'MRSWLK1') {
            $sqlRemminderWithCount = "SELECT id, tanggal_pkb
                FROM `service_data_pkb_last`
                ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";

            $stmt = $conn->prepare($sqlRemminderWithCount);
            $stmt->execute();
            $rowRwc  = $stmt->rowCount();
            $dataRwc = $stmt->fetchAll();

            $x = 0;
            $i = 0;

            if ($rowRwc != 0) {
                foreach ($dataRwc as $valRwc) {
                    $tglAwal  = new DateTime($valRwc['tanggal_pkb']);
                    $tglAkhir = new DateTime();
                    $diff     = date_diff( $tglAwal, $tglAkhir );
                    $jmlHari  = (int)$diff->days;

                    if ($jmlHari > 180 && $jmlHari < 270) {
                        $i++;
                    } else {
                        $x++;
                    }
                }
            }
        } else {
            $sqlRemminderWithCount = "SELECT id, tanggal_pkb
                FROM `service_data_pkb_last`
                WHERE sa = '".$keySa."'
                ORDER BY `service_data_pkb_last`.`tanggal_pkb` DESC";

            $stmt = $conn->prepare($sqlRemminderWithCount);
            $stmt->execute();
            $rowRwc  = $stmt->rowCount();
            $dataRwc = $stmt->fetchAll();

            $x = 0;
            $i = 0;

            if ($rowRwc != 0) {
                foreach ($dataRwc as $valRwc) {
                    $tglAwal  = new DateTime($valRwc['tanggal_pkb']);
                    $tglAkhir = new DateTime();
                    $diff     = date_diff( $tglAwal, $tglAkhir );
                    $jmlHari  = (int)$diff->days;

                    if ($jmlHari > 180 && $jmlHari < 270) {
                        $x++;
                    } else {
                        $i++;
                    }
                }
            }
        }
