<?php

// make function sum when not exist
if (!function_exists('sum')) {
    function sum($a, $b)
    {
        return $a + $b;
    }
}

// make function USD to Rp with with format Rp 28.000,00
if (!function_exists('usd_to_rp')) {
    function usd_to_rp($usd)
    {
        // if($usd === null || $usd === 0) {
        //     return 'Rp 0,00';
        // }

        if(!is_numeric($usd)) {
            $usd = 0;
        }

        return 'Rp ' . number_format($usd * 14000, 2, ',', '.');
    }
}


;?>
