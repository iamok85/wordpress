<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
 
 use lib\controllers\ReportsSearchPost;

 $reports=new ReportsSearchPost();
 $reports->idFilter(array(18));
 
 debug($reports->get_result_set());
 
 
 ?>