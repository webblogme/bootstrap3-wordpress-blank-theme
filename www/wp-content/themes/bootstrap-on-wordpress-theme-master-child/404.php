<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/bootstrap-utilities.php for info on BsWp::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Bootstrap 3.3.7
 * @autor 		Babobski
 */
?>
<?php BsWp::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 text-center" style="font-size:3em; padding-top:50px;" >
		
		
			<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>
			
			<h3><?php echo __('Page not found', 'wp_babobski'); ?></h3>

		</div>
	</div>
</div>

<?php BsWp::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>