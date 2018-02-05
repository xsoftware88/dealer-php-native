<?php

if ($sr == 'Akurat Appointment'
|| $sr == 'Akurat Belum Ada Waktu'
|| $sr == 'Akurat Datang Sendiri'
|| $sr == 'Invalid Dijual'
|| $sr == 'Early KM Belum Sampai'
|| $sr == 'Early Reminder Lain Waktu'
|| $sr == 'Lost Masuk Bengkel Lain'
) {
    $dataRKpi[$val['sa']]['tersambung'][]     = 1;
    $dataRKpi[$val['sa']]['data_terkelola'][] = 1;

    if ($sr == 'Akurat Appointment') {
        $dataRKpi[$val['sa']]['appoitment'][] = 1;
    } else if ($sr == 'Akurat Appointment') {
        $dataRKpi[$val['sa']]['appoitment'][] = 0;
    }

} else {
    $dataRKpi[$val['sa']]['tersambung'][]     = 0;
    $dataRKpi[$val['sa']]['data_terkelola'][] = 1;
    $dataRKpi[$val['sa']]['appoitment'][]     = 0;
}
