<?php /* Template Name: custompage-home */ ?>

<?php BsWp::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php 

//POLYLANG PLUG IN / GET CURRENT LANGUAGE
$currentLanguage=pll_current_language();

$t1=get_field('box1', url_to_postid(site_url('homepage')));
$t2=get_field('box2', url_to_postid(site_url('homepage')));
$t3=get_field('box3', url_to_postid(site_url('homepage')));

?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="container">
	<div class="row">
		
			<div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
			<?php the_content(); ?>
			</div>
		
		</div>
</div>

<?php endwhile; ?>


<?php BsWp::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>