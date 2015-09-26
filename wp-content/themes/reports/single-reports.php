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
		<article>
		<header class="entry-header">
		
		<h1 class="entry-title">
			<?php 
				$reports_titles=get_post_meta(get_the_ID(),'reports_titles');
				echo $reports_titles[0];
			?>
		</h1>				
	</header>
		 <?	
			$reports_filters_groups=get_post_meta(get_the_ID(),'reports_filters_groups');
			$reports_options=get_post_meta(get_the_ID(),'reports_options');
			?>
			<div class="entry-content">
			
			<?php 
				
				echo load_report($reports_filters_groups[0],$reports_options[0]);
				 reportApp_post_nav(); 
			?>
			</div>
		
		</article>
		<?php //query_posts($query_string."&showposts=10"); ?>
		<?php comments_template(); ?>
		</div><!-- #content -->
		
		
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer('reports'); ?>