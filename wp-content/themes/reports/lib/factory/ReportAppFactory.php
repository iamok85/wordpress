<?php

/**
 * V8 Data Access Factory
 */

use lib\controllers\ReportsSearchPost;

class ReportAppFactory
{
    public static function ReportsManager() { return new ReportsSearchPost(); }
   
}