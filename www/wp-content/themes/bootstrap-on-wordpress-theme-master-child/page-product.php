<?php /* Template Name: custompage-product */ ?>

<?php BsWp::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php $currentLanguage=pll_current_language(); ?>


<div class="container-fluid topbg" >

	<div class="container <?php echo ($currentLanguage == 'th' ? 'thFont' : ''); ?>">
		<div class="row">

		
			<div class="col-xs-12 col-sm-10  col-sm-offset-1 productpage">

				
				
				<!-- datas from page start -->
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				
				<h1 title="<?php the_title(); ?>" ><?php the_title(); ?></h1>
				
					<?php the_content(); ?>
				<?php //comments_template( '', true ); ?>
				<?php endwhile; ?>
				<!-- datas from page end -->
				
			</div>
			
		</div>
	</div>

</div>

<div class="container <?php echo ($currentLanguage == 'th' ? 'thFont' : ''); ?>">
	<div class="row">
		
		<div class="col-xs-12 col-sm-10  col-sm-offset-1 productpage">
		
		<?php
		
		//RETRIVE POST SLUG ON THIS PAGE
		global $post;
		$retrive_post_slug=$post->post_name;
		
		$args = array(
				'post_type' => 'post', 
				'posts_per_page' => 999,
				'category_name' => $retrive_post_slug, 
				'order' => 'DESC', 
				'orderby' => 'post_date',
				//'relation' => 'OR',
				array(
					'meta_key' => 'price', //ACF DATA
				),
			);
		
		
		//$query = new WP_Query('category_name=engraving-nametags&posts_per_page=999');
		
		
		$query = new WP_Query( $args );
		
		$numrows =  $query->post_count;
		
		//SEE IF THIS PAGE SHOW FILTER?
		$nofilter=get_field('filter', url_to_postid(site_url($retrive_post_slug)));
		
		if($numrows<=2) { $tooless=1; }
		
		if($nofilter!=1) {
		
		?>
		
		<h3 class="showing" id="showing" ><?php echo ($currentLanguage == 'en' ? 'Showing' : 'แสดง'); ?> <span id="count" ><?php echo $numrows; ?></span> <?php echo ($currentLanguage == 'en' ? 'items' : 'รายการ'); ?> <a href="#" onclick="return false;" id="resetShow" style="display:none;" ><?php echo ($currentLanguage == 'en' ? 'Click to reset a filter' : 'ยกเลิกคำค้น'); ?></a></h3>
		
		<form class="form-inline">
		  <div class="form-group">
			<label style="margin:0 5px 0 0;" ><?php echo ($currentLanguage == 'en' ? 'Filter items with keyword' : 'ค้นหาตามคีย์เวิร์ด'); ?></label>
		  </div>
		  <div class="form-group">
			<input type="text" class="form-control" id="searchInput" placeholder="color size type..." autofocus>
		  </div>
		  
		  <?php } ?>
		

		<div class="clearfix"></div>
		
		<div class="row mt-20">
		
		<div class="col-xs-12" id="Gwrapper">
		<div id="<?php echo ($tooless == '' ? 'Gcolumns' : ''); /*2 COLUMN IF LESS THAN 2*/ ?>">
		
		<?php  

		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();


				echo '<div class="pin fe-grid1" >';

				$fullimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

				if (has_post_thumbnail()) {
					echo '<a href="' . $fullimage[0] . '" class="fancybox">';
					the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' ) );
					echo '</a>';
				}
				
				echo '<h3>'.get_the_title().'</h3>';
				
				the_content();
				
				$price=get_field('price');
				
				if($price!='') {
				
					echo '<h5>'.get_field('price').' THB / ea.</h5>';
				
				}
			
			echo '</div>';

		endwhile;
		endif;
		
	?>

	</div>
	</div>
	
	</div>


<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/hilighter/jquery.highlight.js"></script>

<script>
	
	jQuery(function($) {
		
		function countElem(elem) {
			var t_count = $('#Gcolumns div.fe-grid1:visible').length;
			//console.log("count" + t_count);
			return t_count;
		}
	
		$('#searchInput').on('keyup', function() {
			//console.log("do task");
			$('#Gcolumns div').unhighlight();
			$('#Gcolumns div').highlight($(this).val());
			$("#resetShow").removeAttr('style');
			$("#showing span#count").html(countElem());
			if(this===NULL) { $("#resetShow").css("display", "none"); }
		});
		
		$('#resetShow').on('click', function() {
			//console.log("do reset");
			$('#searchInput').val('');
			$('#Gcolumns div').unhighlight();
			$("#resetShow").css("display", "none");
			jets.search(''); //FIND EMPTY FOR RESET
			$("#showing span#count").html(countElem());
		});
		
	});
</script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jets/jets.min.js"></script>

<script>
// JET FILTER SEARCH
var jets = new Jets({
  searchTag: '#searchInput',
  contentTag: '#Gcolumns',
  columns: [0,1,2] // optional, search by first column only
});
</script>
	
	</div><!-- end Gcolumns -->

				</div><!--main left col end-->

	</div>
</div>

<?php BsWp::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>