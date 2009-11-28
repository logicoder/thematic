<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
<?php

get_header();

thematic_abovecontainer();

?>
	<div id="container">
		<div id="content">

<?php the_post(); ?>
			<?php thematic_navigation_above();?>

<?php get_sidebar('single-top') ?>

<?php thematic_singlepost() ?>
			
<?php get_sidebar('single-insert') ?>

			<?php thematic_navigation_below();?>

<?php thematic_comments_template(); ?>

<?php get_sidebar('single-bottom') ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php 

    thematic_belowcontainer();

    thematic_sidebar();
    
    get_footer();
?>