<?php
if (! function_exists('format_uang')) {
    function format_uang($angka)
    {
        return number_format($angka, 0, ',', '.');
    }
}
