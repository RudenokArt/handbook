<?php 

// РЕГИСТРАЦИЯ ТЕМЫ В STYLE.CSS
/**
 * Theme Name:  theme1
 Author: art
 */

// https://underscores.me/ Генератор тем


// Подключить пролог без шапки
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');


// Включить поддержку миниатюр
add_theme_support( 'post-thumbnails' );
// Включить поддержку логотипа
add_action('after_setup_theme', static function () {
	add_theme_support('custom-logo', []);
});
// Поддержка title
add_theme_support('title_tag');
// Поддержка меню
add_theme_support('menus')
// Отключить админ-бар в публичной части
add_filter( 'show_admin_bar', '__return_false' );


// Получить URL логотипа:
 wp_get_attachment_url(get_theme_mod('custom_logo'));
// Получить favicon
 echo  get_site_icon_url();

// подключение скриптов и стилей
add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_script('jquery');
	 wp_enqueue_style('dashicons');
	wp_enqueue_style('bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
	wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], false, ['in_footer' => true]);
	wp_enqueue_script( 'script_js', get_template_directory_uri() . '/js/script.js');
	wp_enqueue_style( 'style_css', get_stylesheet_directory_uri() . '/css/style.css' );
});


// Подключение файла php
 get_template_part('core/AdminRouter');

// Путь до темы (php path);
 get_template_directory();

// url темы
 get_stylesheet_directory_uri();
 get_template_directory_uri(); // для дочерних тем

// Получить слаг текущей страницы
 $current_page_slug = get_post()->post_name;

// Очистка текста поста:
 sanitize_text_field($str);

// получить url миниатюры поста
 get_the_post_thumbnail_url($postId);


// SQL запрос к БД
 $sql=$wpdb->get_results('SELECT `post_content` FROM `wp_posts`');
 print_r($sql);





// Я решил свою проблему с помощью своего решения под номером # 04 Смотрите ниже, что я пробовал:
// 1- Убедитесь, что установлены ссылки на базу данных wp_option
// /* MySQL: */
// update wp_options set option_value = 'http://example.com' where option_name = 'siteurl';
// update wp_options set option_value = 'http://example.com' where option_name = 'home';
// 2 - дополнительно указать URL-адрес в файл wp-config.php
// define('WP_HOME','http://example.com');
// define('WP_SITEURL','http://example.com');
// 3- Очистить кэш с сервера
// 4- Очистите кэш вашего браузера и историю (Ура!!! это решило мою проблему без перенаправления)
// В Chrome перейдите к chrome://settings/clearBrowserData и очистите кэш изображений и файлов.