<?php

function learningWordPress_resources() {
	
	wp_enqueue_style('style', get_stylesheet_uri());
	
}

add_action('wp_enqueue_scripts', 'learningWordPress_resources');



// Get top ancestor
function get_top_ancestor_id() {
	
	global $post;
	
	if ($post->post_parent) {
		$ancestors = array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
		
	}
	
	return $post->ID;
	
}

// Does page have children?
function has_children() {
	
	global $post;
	
	$pages = get_pages('child_of=' . $post->ID);
	return count($pages);
	
}

// Customize excerpt word count length
function custom_excerpt_length() {
	return 22;
}

add_filter('excerpt_length', 'custom_excerpt_length');



// Theme setup
function learningWordPress_setup() {
	
	// Navigation Menus
	register_nav_menus(array(
		'primary' => __( 'Primary Menu'),
		'footer' => __( 'Footer Menu'),
	));
	
	// Add featured image support
	add_theme_support('post-thumbnails');
	add_image_size('small-thumbnail', 180, 120, true);
	add_image_size('square-thumbnail', 80, 80, true);
	add_image_size('banner-image', 920, 210, array('left', 'top'));
	
	// Add post type support
	add_theme_support('post-formats', array('aside', 'gallery', 'link'));
}

add_action('after_setup_theme', 'learningWordPress_setup');

// Add Widget Areas
function ourWidgetsInit() {
	
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 1',
		'id' => 'footer1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 2',
		'id' => 'footer2',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 3',
		'id' => 'footer3',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 4',
		'id' => 'footer4',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
}

add_action('widgets_init', 'ourWidgetsInit');

// customize appearance options

function learningWordPress_customize_register($wp_customize){
	// link custom color
	$wp_customize->add_setting('lwp_link_color',[
		'default' => '#006ec3',
		'transport' => 'refresh',
	]);
	// link custom hover color
	$wp_customize->add_setting('lwp_link_hover_color',[
		'default' => '#0000ff',
		'transport' => 'refresh',
	]);
	// button custom color
	$wp_customize->add_setting('lwp_btn_color',[
		'default' => '#006ec3',
		'transport' => 'refresh',
	]);
	// button custom hover color
	$wp_customize->add_setting('lwp_btn_hover_color',[
		'default' => '#004C87',
		'transport' => 'refresh',
	]);
	// add section to Customize area
	$wp_customize->add_section('lwp_standard_colors',[
		'title' => __('Standard Colors', 'LearningWordPress'),
		'priority' => 30,
	]);
	// add control link custom color
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lwp_link_color_control', [
		'label' => __('Link Color', 'LearningWordPress'),
		'section' => 'lwp_standard_colors',
		'settings' => 'lwp_link_color',
	]));
	// add control link custom hover color
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lwp_link_hover_color_control', [
		'label' => __('Link Hover Color', 'LearningWordPress'),
		'section' => 'lwp_standard_colors',
		'settings' => 'lwp_link_hover_color',
	]));
	// add control button hover color
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lwp_btn_color_control', [
		'label' => __('Button Color', 'LearningWordPress'),
		'section' => 'lwp_standard_colors',
		'settings' => 'lwp_btn_color',
	]));
	// add control button custom hover color
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'lwp_btn_hover_color_control', [
		'label' => __('Button Hover Color', 'LearningWordPress'),
		'section' => 'lwp_standard_colors',
		'settings' => 'lwp_btn_hover_color',
	]));
}
// add action for custom link and button colors
add_action('customize_register', 'learningWordPress_customize_register');

// output customized link and button CSS
function learningWordPress_customize_css(){ ?>
	<style type="text/css">
		a:link, a:visited{
			color: <?php echo get_theme_mod('lwp_link_color'); ?>;
		}

		a:hover, a:active{
			color: <?php echo get_theme_mod('lwp_link_hover_color'); ?>;	
		}

		.site-header nav ul li.current-menu-item a:link,
		.site-header nav ul li.current-menu-item a:visited,
		.site-header nav ul li.current-page-ancestor a:link,
		.site-header nav ul li.current-page-ancestor a:visited{
			background-color: <?php echo get_theme_mod('lwp_link_color'); ?>;
		}

		.btn-a,
		.btn-a:link,
		.btn-a:visited,
		div.hd-search #searchsubmit{
			background-color: <?php echo get_theme_mod('lwp_btn_color'); ?>;
		}

		.btn-a:hover,
		div.hd-search #searchsubmit:hover {
			background-color: <?php echo get_theme_mod('lwp_btn_hover_color'); ?>;;
		}
	</style>
}
<?php }
// add customized css to head section of site
add_action('wp_head', 'learningWordPress_customize_css');

// add footer callout section to admin appearance customize screen
function lwp_footer_callout($wp_customize){
	$wp_customize->add_section('lwp-footer-callout-section', [
		'title' => 'Footer Callout'
	]);

	$wp_customize->add_setting('lwp-footer-callout-display', [
		'default' => 'No'
	]);

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lwp-footer-callout-display-control', [
			'label' => 'Display this section?',
			'section' => 'lwp-footer-callout-section',
			'settings' => 'lwp-footer-callout-display',
			'type' => 'select',
			'choices' => ['No' => 'No', 'Yes' => 'Yes']
	]));

	$wp_customize->add_setting('lwp-footer-callout-headline', [
		'default' => 'Type Headline Text Here...',
	]);

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lwp-footer-callout-headline-control', [
			'label' => 'Headline',
			'section' => 'lwp-footer-callout-section',
			'settings' => 'lwp-footer-callout-headline'
	]));

	$wp_customize->add_setting('lwp-footer-callout-text', [
		'default' => 'Type Body Text Here...',
	]);

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lwp-footer-callout-text-control', [
			'label' => 'Callout Text',
			'section' => 'lwp-footer-callout-section',
			'settings' => 'lwp-footer-callout-text',
			'type' => 'textarea'
	]));

	$wp_customize->add_setting('lwp-footer-callout-link');

	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'lwp-footer-callout-link-control', [
			'label' => 'Callout Link',
			'section' => 'lwp-footer-callout-section',
			'settings' => 'lwp-footer-callout-link',
			'type' => 'dropdown-pages'
	]));

	$wp_customize->add_setting('lwp-footer-callout-image');

	$wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'lwp-footer-callout-image-control', [
			'label' => 'Callout Image',
			'section' => 'lwp-footer-callout-section',
			'settings' => 'lwp-footer-callout-image',
			'width' => 750,
			'height' => 500
	]));
}

add_action('customize_register', 'lwp_footer_callout');