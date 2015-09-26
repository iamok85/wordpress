<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */


get_header('reports');
 use lib\controllers\ReportsSearchPost;

 
 $reports=new ReportsSearchPost();
 $reports->allFilter(); 
 $all_reports=$reports->get_result_set();
 
 foreach($all_reports as $one_report){
	//debug($one_report);
	echo '<h1>'.(isset($one_report['reports_titles'])?$one_report['reports_titles']:"").'</h1>';
	
	$report_report=load_report($one_report['reports_filters_groups'],$one_report['reports_options']);
	
	echo $report_report;
 }
 
 get_footer('reports');
 ?>