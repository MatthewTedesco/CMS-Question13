<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */

if ( ! defined('MESMERIZE_THEME_REQUIRED_PHP_VERSION')) {
    define('MESMERIZE_THEME_REQUIRED_PHP_VERSION', '5.3.0');
}

add_action('after_switch_theme', 'mesmerize_check_php_version');

function mesmerize_check_php_version()
{
    // Compare versions.
    if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '<')) :
        // Theme not activated info message.
        add_action('admin_notices', 'mesmerize_php_version_notice');
        
        
        // Switch back to previous theme.
        switch_theme(get_option('theme_switched'));
        
        return false;
    endif;
}

function mesmerize_php_version_notice()
{
    ?>
    <div class="notice notice-alt notice-error notice-large">
        <h4><?php _e('Mesmerize theme activation failed!', 'mesmerize'); ?></h4>
        <p>
            <?php _e('You need to update your PHP version to use the <strong>Mesmerize</strong>.', 'mesmerize'); ?> <br/>
            <?php _e('Current php version is:', 'mesmerize') ?> <strong>
                <?php echo phpversion(); ?></strong>, <?php _e('and the minimum required version is ', 'mesmerize') ?>
            <strong><?php echo MESMERIZE_THEME_REQUIRED_PHP_VERSION; ?></strong>
        </p>
    </div>
    <?php
}

if (version_compare(phpversion(), MESMERIZE_THEME_REQUIRED_PHP_VERSION, '>=')) {
    require_once get_template_directory() . "/inc/functions.php";
    
     
    
    if ( ! mesmerize_can_show_cached_value("mesmerize_cached_kirki_style_mesmerize")) {
        
        if ( ! mesmerize_skip_customize_register()) {
            do_action("mesmerize_customize_register_options");
        }
    }
    
} else {
    add_action('admin_notices', 'mesmerize_php_version_notice');
}

/*List Posts.*/
function recent_posts_function($atts){
   extract(shortcode_atts(array(
      'posts' => 1,
   ), $atts));

   $return_string = '<ul>';
   query_posts(array('orderby' => 'date', 'order' => 'DESC' , 'showposts' => $posts));
   if (have_posts()) :
      while (have_posts()) : the_post();
         $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
      endwhile;
   endif;
   $return_string .= '</ul>';

   wp_reset_query();
   return $return_string;
}
add_shortcode('recent-posts', 'recent_posts_function');

/*Google Map for Contact Us!.*/
function googlemap_function($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '640',
      "height" => '450',
      "src" => ''
   ), $atts));
   return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}
add_shortcode("googlemap", "googlemap_function");

/*PDF Functionality*/
function pdf_function($attr, $url) {
   extract(shortcode_atts(array(
       'width' => '640',
       'height' => '480'
   ), $attr));
   return '<iframe src="http://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' .$width. '; height:' .$height. ';">Your browser does not support iframes</iframe>';
}
add_shortcode('pdf', 'pdf_function');

/*Contact Button*/
function custom_button_shortcode( $atts, $content = null ) {
// shortcode attributes
   extract( shortcode_atts( array(
       'url'    => '',
       'title'  => '',
       'target' => '',
       'text'   => '',
    ), $atts ) ); 
   $content = $text ? $text : $content;
// Returns the button with a link
   if ( $url ) {
       $link_attr = array(
           'href'   => esc_url( $url ),
           'title'  => esc_attr( $title ),
           'target' => ( 'blank' == $target ) ? '_blank' : '',
           'class'  => 'custombutton'
       );
       $link_attrs_str = '';
       foreach ( $link_attr as $key => $val ) {
           if ( $val ) {
               $link_attrs_str .= ' ' . $key . '="' . $val . '"';
            }
        }
        return '<a' . $link_attrs_str . '><span>' . do_shortcode( $content ) . '</span></a>';
    }
    // Return as span when no link defined
    else {
        return '<span class="custombutton"><span>' . do_shortcode( $content ) . '</span></span>';
    }
}
add_shortcode( 'custombutton', 'custom_button_shortcode' );

/*Restricted Button*/
function custom_button1_shortcode( $atts, $content = null ) {
// shortcode attributes
   extract( shortcode_atts( array(
       'url'    => '',
       'title'  => '',
       'target' => '',
       'text'   => '',
    ), $atts ) ); 
   $content = $text ? $text : $content;
// Returns the button with a link
   if ( $url ) {
       $link_attr = array(
           'href'   => esc_url( $url ),
           'title'  => esc_attr( $title ),
           'target' => ( 'blank' == $target ) ? '_blank' : '',
           'class'  => 'custombutton1'
       );
       $link_attrs_str = '';
       foreach ( $link_attr as $key => $val ) {
           if ( $val ) {
               $link_attrs_str .= ' ' . $key . '="' . $val . '"';
            }
        }
        return '<a' . $link_attrs_str . '><span>' . do_shortcode( $content ) . '</span></a>';
    }
    // Return as span when no link defined
    else {
        return '<span class="custombutton1"><span>' . do_shortcode( $content ) . '</span></span>';
    }
}
add_shortcode( 'custombutton1', 'custom_button1_shortcode' );

/*Youtube video*/
function youtube($atts) {
	extract(shortcode_atts( array(
		'value' => 'http://',
		'width' => '500',
		'height' => '500',
		'name' => 'movie',
		'allowFullScreen' => 'true',
		'allowScriptAccess' => 'always',
		'controls' => '1',
	), $atts));
	return '<object style="height: '.$height.'px; width: '.$width.'px"><param name="'.$name.'" value="'.$value.'"><param name="allowFullScreen" value="'.$allowFullScreen.'"><param name="allowScriptAccess" value="'.$allowScriptAccess.'"><embed src="'.$value.'" type="application/x-shockwave-flash" allowfullscreen="'.$allowFullScreen.'" allowScriptAccess="'.$allowScriptAccess.'" width="'.$width.'" height="'.$height.'"></object>';
}
add_shortcode('youtube', 'youtube');

/*Inserting an image*/
function outofstock_function() {
     return "<img src=\"https://i.pinimg.com/originals/29/9b/c3/299bc31cb5379fffaad0fa9bd7f0b453.jpg\" 
    alt=\"doti-rating\" height=\"100\" width=\"700\" style=\"width:60%\" \"class=\"centre\" />";
}
add_shortcode('outofstock', 'outofstock_function');

/*Table*/
function purchases_function(){
	return '<br/>
		<p>*Estimate time until product delivered:</p>
		<table style="width:100%">
			<tr>
				<th>Purchased Products</th>
				<th>Prescription Vertification</th>
				<th>Average Time for Packaging</th>
				<th>Type of Delivery</th>
			</tr>
			<tr>
				<td>Medicinal Drugs</td>
				<td>3 days to recieve prescription</td>
				<td>3 hours</td>
				<td>Pickup and Delivery (2 days)</td>
			</tr>
			<tr>
				<td>Utlities</td>
				<td>N/A</td>
				<td>3 hours</td>
				<td>Pickup and Delivery (2 days)</td>
			</tr>
		</table>';
}
add_shortcode('purchases','purchases_function');

function youtube_video(){
     return "<iframe src=\"https://www.youtube.com/embed/IZuTNOxTA-Q\" width=\"640\" height=\"360\" frameborder=\"0\" allowfullscreen></iframe>";
}
add_shortcode('youtube_video', 'youtube_video_function');

// register the shortcode to wrap html around the content
function wptuts_responsive_video_shortcode( $atts ) {
    extract( shortcode_atts( array (
        'identifier' => ''
    ), $atts ) );
    return '<div class="wptuts-video-container"><iframe src="//www.youtube.com/embed/' . $identifier . '" height="300" width="450" allowfullscreen="" frameborder="0"></iframe></div>
    <!--.wptuts-video-container-->';
}
add_shortcode ('responsive-video', 'wptuts_responsive_video_shortcode' );

// Register stylesheet with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
function wptuts_responsive_video_add_stylesheet() {
    wp_register_style( 'wptuts_responsive_video_style', plugins_url( 'style.css', __FILE__ ) );
    wp_enqueue_style( 'wptuts_responsive_video_style' );
}
add_action( 'wp_enqueue_scripts', 'wptuts_responsive_video_add_stylesheet' );
