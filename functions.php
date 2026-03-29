<?php

if (!function_exists('swim_theme_setup')) {
	function swim_theme_setup() {
		add_theme_support('title-tag');

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(1568, 9999);

		register_nav_menus(
			array(
				'primary' => esc_html__('Primary menu', 'swim'),
				'secondary' => __('Secondary menu', 'swim'),
				'logged_in_menu' => __('Logged In menu', 'swim'),
				'logged_out_menu' => __('Logged Out menu', 'swim'),
				'footer'  => __('Footer menu', 'swim'),
				'social'  => __('Social menu', 'swim'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		add_theme_support('custom-logo', array());
	}
}
add_action('after_setup_theme', 'swim_theme_setup');

function swim_settings_init() {
	register_setting(
		'general',
		'swim_address',
		array(
			'type'				=> 'string',
			'sanitize_callback'	=> 'sanitize_text_field',
			'default' => ''
		)
	);
	register_setting(
		'general',
		'swim_phone',
		array(
			'type'				=> 'number',
			'sanitize_callback'	=> 'absint',
			'default' => ''
		)
	);
	register_setting(
		'general',
		'swim_email',
		array(
			'type'				=> 'string',
			'sanitize_callback'	=> 'sanitize_text_field',
			'default' => ''
		)
	);

	add_settings_section('swim_contact_info', 'Contact Information', 'swim_contact_section_callback', 'general');
	add_settings_field(
		'swim_address',
		__('Address'),
		'swim_settings_field_callback',
		'general',
		'swim_contact_info',
		array(
			'id'	=> 'swim_address'
		)
	);
	add_settings_field(
		'swim_phone',
		__('Phone'),
		'swim_settings_field_callback',
		'general',
		'swim_contact_info',
		array(
			'id'	=> 'swim_phone',
			'type'	=> 'tel'
		)
	);
	add_settings_field(
		'swim_email',
		__('Email'),
		'swim_settings_field_callback',
		'general',
		'swim_contact_info',
		array(
			'id'	=> 'swim_email',
			'type'	=> 'email'
		)
	);
}

function swim_contact_section_callback() {
	echo '<hr/>';
}

function swim_settings_field_callback($args) {
	$setting = get_option($args['id']);
?>
	<input type="<?= $args['type'] ?? 'type'; ?>" name="<?= $args['id']; ?>" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
<?php
}
add_action('admin_init', 'swim_settings_init');

function swim_register_styles() {
	wp_enqueue_style('swim_style', get_template_directory_uri() . "/style.css", array(), wp_get_theme()->get('Version'));
	wp_enqueue_style('fontawesome_style', get_template_directory_uri() . "/assets/css/all.min.css", array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'swim_register_styles');

function swim_register_scripts() {
	wp_enqueue_script('swim_scripts', get_template_directory_uri() . "/index.js", array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'swim_register_scripts');

function swim_blog_favicon() {
	echo "";
}
add_action('wp_head', 'swim_blog_favicon');

function swim_widgets_init() {
	register_sidebar(array(
		'id' => 'primary-sidebar',
		'name' => __('Primary Sidebar', 'SWIM'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar(array(
		'id' => 'secondary-sidebar',
		'name' => __('Secondary Sidebar', 'SWIM'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}
add_action('widgets_init', 'swim_widgets_init');

function swim_bubble_list_shortcode() {
	ob_start();
	get_template_part('template-parts/bubble', 'list');
	return ob_get_clean();
}
add_shortcode('swim_bubble_list', 'swim_bubble_list_shortcode');

function swim_archive_title($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	}

	return $title;
}

add_filter('get_the_archive_title', 'swim_archive_title');

require 'classes/swim-social-walker.php';
require 'classes/swim-categories-image.php';

new SWIMCategoriesImages();

function swim_redirect_after_logout() {
	wp_redirect('home');
	exit();
}
add_action('wp_logout', 'swim_redirect_after_logout');
