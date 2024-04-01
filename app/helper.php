<?php


if (!function_exists('custom_date')) {
    function custom_date($data)
    {
        $format = 'd-m-Y h:i:s A';
        $formatted_date = date($format, strtotime($data));

        return $formatted_date;
    }
}
