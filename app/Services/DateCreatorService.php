<?php

namespace App\Services;

/**
 * A service offering a static date creation functions.
 **/
class DateCreatorService
{
    /**
     *Return a start date.
     **/
    public static function getMonday()
    {
        $day = date('w');
        $day -= 1;
        $start = date('Y-m-d', strtotime('-'.$day.' days'));

        return $start;
    }
}
