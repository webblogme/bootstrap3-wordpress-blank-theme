<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/bootsrap-utilities.php for info on BsWp::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Bootstrap 3.3.7
 * @autor 		Babobski
 */
?>
<?php BsWp::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">

<div class="content">
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
		<h2>Something went wrong!</h2>
		<?php //the_content(); ?>
		<?php //comments_template( '', true ); ?>
		<p>Sorry, Current page are set to no show any content. to view them please select them from category menu above.</p>
	
	<?php endwhile; ?>
</div>


			
		</div>
	</div>
</div>

<?php BsWp::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
