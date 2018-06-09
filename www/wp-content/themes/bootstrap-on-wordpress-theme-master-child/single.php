<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/bootstrap-utilities.php for info on BsWp::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Bootstrap 3.3.7
 * @autor 		Babobski
 */
 
//NO SHOW THIS PAGE SO REDIRECT TO HOMEPAGE
 
 if ( ! is_admin() ) {
     wp_redirect( home_url() );
     exit;
}
 
?>