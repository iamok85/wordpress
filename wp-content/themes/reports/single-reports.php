<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header('reports'); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		
		 <?
			echo load_report();
		 ?>
			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer('reports'); ?>