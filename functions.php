<?php
/**
 * vinire functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vinire
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vinire_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on vinire, use a find and replace
		* to change 'vinire' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'vinire', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'vinire' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'vinire_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'vinire_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vinire_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'vinire_content_width', 640 );
}
add_action( 'after_setup_theme', 'vinire_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vinire_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'vinire' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'vinire' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'vinire_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vinire_scripts() {
	wp_enqueue_style( 'vinire-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'vinire-style', 'rtl', 'replace' );

    wp_enqueue_style( 'vinire-style-main', get_template_directory_uri() . '/css/style.css', _S_VERSION );

	wp_enqueue_script( 'vinire-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    wp_enqueue_style('swiper', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    // Swiper JS
    wp_enqueue_script('swiper', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), null, true);

    // Инициализация Swiper JS
}
add_action( 'wp_enqueue_scripts', 'vinire_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


function top_content($atts, $content = null) {
    // Установите значения атрибутов по умолчанию
    $atts = shortcode_atts(
        array('title' => 'Заголовок по умолчанию', 'file' => 'block1'),
        $atts
    );

    // Путь к файлу блока
    $block_path = get_template_directory() . '/blocks/block1.php';

    // Переменные для файла блока
    $title = $atts['title'];

    // Начало буферизации вывода
    ob_start();

    // Убедитесь, что файл существует, прежде чем его подключить
    if (file_exists($block_path)) {
        include $block_path;
    } else {
        return '<p>Файл блока не найден.</p>';
    }

    // Возвращаем содержимое буфера и очищаем его
    return ob_get_clean();
}
add_shortcode('custom_block', 'top_content');



function my_swiper_slider_shortcode($atts) {
    // Обеспечиваем работу с множественными слайдами
    $atts = (array) $atts;
    $slide_data = array();

    if(isset($atts['slide'])){
        $slides = explode(',', $atts['slide']);
        foreach ($slides as $slide) {
            list($image, $title, $description) = array_pad(explode('|', $slide), 3, '');
            $slide_data[] = array(
                'image' => $image,
                'title' => $title,
                'description' => $description
            );
        }
    }

    // подключаем файл шаблона слайдера
    $slider_template = get_template_directory() . '/blocks/block2.php';

    // передаём данные в шаблон
    ob_start();
    if (file_exists($slider_template)) {
        include $slider_template;
    }
    return ob_get_clean();
}
add_shortcode('slider', 'my_swiper_slider_shortcode');



function unified_dropdown_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title' => '',
        'delimiter' => '|',
    ), $atts);

    $content = wpautop($content, false);
    $content = strip_tags($content, '<br><br/>');
    $content = str_replace(array('<br />', '<br>', '<br/>'), "\n", $content);
    $content = trim($content);

    // Разделяем контент на строки для каждого элемента списка
    $items = explode("\n", $content);
    $delimiter = $atts['delimiter'];
    $title_dropdown = $atts['title'];
    // Удаляем пустые строки из массива элементов
    $items = array_filter($items, function($item) {
        return trim($item) !== '';
    });

    ob_start();
    include get_template_directory() . '/blocks/block3.php';
    return ob_get_clean();
}
add_shortcode('unified_dropdown', 'unified_dropdown_shortcode');


function my_simple_content_shortcode($atts, $content = null) {
    $content = do_shortcode($content);

    ob_start();
    include get_template_directory() . '/blocks/block4.php';
    return ob_get_clean();
}
add_shortcode('simple_content', 'my_simple_content_shortcode');

function my_custom_content_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Заголовок',
        'description' => '',
        'link' => '',
        'link_text' => '',
        'short_description' => '',
        'photo' => '',
    ), $atts, 'custom_content');

    // Извлекаем атрибуты для удобства
    extract($atts);

    ob_start();
    include get_template_directory() . '/blocks/block5.php';
    return ob_get_clean();
}
add_shortcode('custom_content', 'my_custom_content_shortcode');

/* Rectangle 415 */



function my_banner_first($atts) {
    $atts = shortcode_atts(array(
        'title' => 'Заголовок',
        'description' => '',
        'link' => '',
        'link_text' => '',
        'photo' => '',
        'text1' => '',  // Добавляем новый текстовый атрибут
        'text2' => '',  // Добавляем новый текстовый атрибут
        'text3' => '',  // Добавляем новый текстовый атрибут
        'text4' => ''   // Добавляем новый текстовый атрибут
    ), $atts, 'custom_content');

    // Извлекаем атрибуты для удобства
    extract($atts);

    ob_start();
    include get_template_directory() . '/blocks/block6.php';
    return ob_get_clean();
}
add_shortcode('banner_main', 'my_banner_first');
