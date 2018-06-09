<?php /* Template Name: custompage-pages */ ?>

<?php BsWp::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<!-- datas from page start -->
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="container-fluid topbg" >

	<div class="container <?php echo ($currentLanguage == 'th' ? 'thFont' : ''); ?>">
		<div class="row">

		
			<div class="col-xs-12 col-sm-10  col-sm-offset-1 productpage">

				<h1 title="<?php the_title(); ?>" ><?php the_title(); ?></h1>
				
								
				
				
			</div>
			
		</div>
	</div>

</div>

<div class="container">
	<div class="row">
	
	
		<div class="col-xs-12 col-sm-10  col-sm-offset-1 col-md-10 col-md-offset-1">

			
				<?php the_content(); ?>
			<?php //comments_template( '', true ); ?>
			
			<!-- datas from page end -->
		
		</div><!--main left col end-->



	</div>
</div>

<?php endwhile; ?>



<?php BsWp::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>