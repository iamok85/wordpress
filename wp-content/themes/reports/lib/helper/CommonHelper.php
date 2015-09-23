<?php

/**
 * Created by PhpStorm.
 * User: dion.tsai
 * Date: 6/09/2015
 * Time: 10:37 AM
 */

namespace lib\helper;

abstract class CommonHelper
{
    public static function getAge($datetime)
    {
        $date1 = date_create($datetime);
        $date2 = date_create(date('Y-m-d h:m:s'));
        $diff = date_diff($date1, $date2);

        $diff_value = "";
        if ($diff->days == 0) {
            if ($diff->h > 1)
                $diff_value = $diff->h . ' Hours ago';
            else
                $diff_value = $diff->h . ' Hour ago';

        } else if ($diff->days <= 7) {

            if ($diff->days > 1)
                $diff_value = $diff->days . ' Days ago';
            else
                $diff_value = $diff->days . ' Day ago';

        } else {
            $diff_value = date_format($date1, "d/m/Y");
        }


        return $diff_value;
    }

    public static function timeToGo($datetime)
    {
        $date1 = date_create($datetime);
        $date2 = date_create(date('Y-m-d'));
        $diff = date_diff($date1, $date2);

        $diff_value = "";
        if ($diff->days == 0) {
            if ($diff->h > 1)
                $diff_value = $diff->h . ' Hours';
            else
                $diff_value = $diff->h . ' Hour';

        } else if ($diff->days <= 7) {

            if ($diff->days > 1)
                $diff_value = $diff->days . ' Days';
            else
                $diff_value = $diff->days . ' Day';

        }

        return $diff_value;
    }
}