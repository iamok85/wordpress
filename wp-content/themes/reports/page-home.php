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
	debug($one_report['reports_filters_groups']);
	echo "<article>";
	?>
	<header class="entry-header">
		
		<h1 class="entry-title">
			<a href="<?php echo get_permalink($one_report['ID'])?>" rel="bookmark"><?php echo (isset($one_report['reports_titles'])?$one_report['reports_titles']:"")?></a>
		</h1>				
	</header>
	
	<?php
	$report_report=load_report($one_report['reports_filters_groups'],$one_report['reports_options']);	?>
	<div class="entry-content">
		<?php echo $report_report;?>
	</div>
	<?php
	echo "</article>";
	
	 //comments_template($one_report['ID']);
		//get_template_part( 'content', get_post_format() );
 }
 
 get_footer('reports');
 ?>