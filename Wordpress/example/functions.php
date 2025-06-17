<?php
add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_style( 'default', get_stylesheet_uri() );
	wp_enqueue_script('jquery');
	wp_enqueue_style('dashicons');
	wp_enqueue_style('bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', [], false, ['in_footer' => true]);
	wp_enqueue_script( 'script_js', get_template_directory_uri() . '/js/script.js', ['bootstrap_js'], false, ['in_footer' => true]);
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/css/style.css', ['bootstrap_css'] );
});

add_action('after_setup_theme', static function () {
	add_theme_support('custom-logo', []);
	add_theme_support('title_tag');
	add_theme_support('menus');
	add_theme_support('post-thumbnails');

	// register_nav_menu( 'header', 'Header menu' );
});

// Длинна превью поста
add_filter( 'excerpt_length', function(){
	return 5;
});
add_filter( 'excerpt_more', function( $more ) {
	return '...';
});


// Область виджетов
add_action( 'widgets_init', function () {
	register_sidebar([
			'id' => 'test_widget_area', // уникальный id
			'name' => 'Тестовая область виджетов', // название сайдбара
			'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
			'before_widget' => '<div class="text-info">', // по умолчанию виджеты выводятся <li>-списком
			'after_widget' => '</div>',
		]);
});

// Добавить новый тип записи
add_action('init', function () {
	$labels = array(
		'name' => 'Услуги',
		'singular_name' => 'Услуги',
		'menu_name' => 'Услуги',
		'name_admin_bar' => 'Услуга',
		'add_new' => 'Добавить новую',
		'add_new_item' => 'Добавить новую запись',
		'new_item' => 'Новая запись',
		'edit_item' => 'Редактировать запись',
		'view_item' => 'Просмотреть запись',
		'all_items' => 'Все записи',
		'search_items' => 'Искать записи',
		'parent_item_colon' => 'Родительская запись:',
		'not_found' => 'Записи не найдены.',
		'not_found_in_trash' => 'Записи в корзине не найдены.'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'service'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields')
	);

	register_post_type('custom_post', $args);
});

if( wp_doing_ajax() ) {
	add_action( 'wp_ajax_testAjax', 'testAjax' );
	add_action( 'wp_ajax_nopriv_testAjax', 'testAjax' );
}

function testAjax($value) {
	print_r($_POST);
	wp_die();
}


// Вставка шорткода
add_shortcode( 'testShortcode', function ( $atts ) {
	return '<b>'.$atts['year'].'</b>';
});
