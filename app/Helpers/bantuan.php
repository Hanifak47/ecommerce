<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}


/**
 * fungsi utnuk merubah integer menjadi rupiuah
 * @return integer
 */
if (!function_exists('toRupiah')) {
    function toRupiah($numb): string
    {
        $hasil = 'Rp ' . number_format($numb, 2, ",", ".");
        return $hasil;
    }
}