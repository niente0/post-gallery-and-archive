<?php
/*
Plugin Name: post gallery
Plugin URI: http://www.zeevm.co.il
Description: Creates a nice post gallery/post archive, uses a choosen category to show a grid list of posts with image, read more and the excerpt.
Version: 0.4
Author URI: ze'ev ma'ayan
Author URI: http://www.zeevm.co.il

/*  TM zeev.co.il */
add_action('init', 'process_post');
//limit number of words in the text under the img
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
//create shortcode things
function process_post(){ 
function button_shortcode( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'cat' => 'cat',
	  'onpage' => 'onpage',
	  'words' => 'words'
      ), $atts ) );
	  $xoutput='<ul class="zeevul">';
	query_posts( array ( 'cat' => $cat, 'posts_per_page' => $onpage));
	if (have_posts()) : while (have_posts()) : the_post();
  // do whatever you want
	$xoutput.='<li><h2 href="'.get_permalink().'">'.get_the_title().'</h2>';

	if(has_post_thumbnail()) { 
		$xoutput.='<div class="entry-thumbnail"><a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a></div>';
		} else {
		$xoutput.='<div class="entry-thumbnail"><a href="'.get_permalink().'"><img src="'.plugins_url().'/post-gallery-and-archive/default-img.png" alt="Image Unavailable" /></a></div>';
		}
	$xoutput.='<p>'.excerpt($words).'</p><a href="'.get_permalink().'">Read More >></a></li>';
endwhile;
wp_reset_query();
endif;
// style it up
$xoutput.='</ul>'.PHP_EOL.'<style>'.PHP_EOL.'ul.zeevul {width:100%;}'.PHP_EOL;
$xoutput.='ul.zeevul li {list-style:none!important;float:left;width:27%;margin-left:2%;margin-top:20px;}'.PHP_EOL;
$xoutput.='ul.zeevul li img{width:100%;height:150px;}'.PHP_EOL;
$xoutput.='ul.zeevul li img:hover{opacity:0.6;filter:alpha(opacity=60); /* For IE8 and earlier */}'.PHP_EOL;
$xoutput.='@media screen and (max-width: 1024px){ul.zeevul li {width:100%;margin-left:0;margin-top:5px;}}'.PHP_EOL;
$xoutput.='</style>';
return $xoutput;
} 
Function archive()  { return sheker();}
add_shortcode('post-gallery', 'button_shortcode');
}?>
