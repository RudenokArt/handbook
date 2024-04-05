<?php 

// РЕГИСТРАЦИЯ ТЕМЫ В STYLE.CSS
/**
 * Theme Name:  theme1
 Author: art
 */

// Очистка текста поста:
 sanitize_textarea_field($str);

// Подключить пролог без шапки
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// Подключение файла php
get_template_part('core/AdminRouter');

// Включить поддержку миниатюр
add_theme_support( 'post-thumbnails' );

// Включить поддержку логотипа
add_action('after_setup_theme', static function () {
	add_theme_support('custom-logo', []);
});

// Получить URL логотипа:
wp_get_attachment_url(get_theme_mod('custom_logo'));

// Получить favicon
echo  get_site_icon_url();

// Путь до темы (php path);
get_template_directory();

// url темы
get_stylesheet_directory_uri();
get_template_directory_uri(); // для дочерних тем

// Проверка пользователя на админа:
print_r(current_user_can('manage_options'));


// SQL запрос к БД
$sql=$wpdb->get_results('SELECT `post_content` FROM `wp_posts`');
print_r($sql);

// Получить слаг текущей страницы
$current_page_slug = get_post()->post_name;


// ===== ДОБАВЛЕНИЕ СВОИХ СТРАНИЦ В АДМИНКУ
add_action( 'admin_menu', 'true_top_menu_page', 25 );
function true_top_menu_page(){
	add_menu_page(
		'Настройки конструктора', // тайтл страницы
		'Настройки конструктора', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'ug_ideal_admin', // ярлык страницы
		'ug_ideal_admin', // функция, которая выводит содержимое страницы
		'dashicons-admin-generic', // иконка, в данном случае из Dashicons
		7 // позиция в меню
	);

	add_submenu_page(
		'ug_ideal_admin',
		'Шаблоны - размеры и цены', // тайтл страницы
		'Шаблоны - размеры и цены', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'ug_ideal_admin_template_size', // ярлык страницы
		'ug_ideal_admin_template_size' // функция, которая выводит содержимое страницы
	);
} 
function ug_ideal_admin () {
	include_once 'ug_ideal-includes/admin.php';
}
function ug_ideal_admin_template_size(){
	include_once 'ug_ideal-includes/admin-template-size.php';
}


// ===== ДОБАВЛЕНИЕ СВОИХ СТРАНИЦ В ПУБЛИЧНУЮ ЧАСТЬ

/*
Template Name: ug_ideal-catalog
*/




?>


Я решил свою проблему с помощью своего решения под номером # 04 Смотрите ниже, что я пробовал:

1- Убедитесь, что установлены ссылки на базу данных wp_option

/* MySQL: */
update wp_options set option_value = 'http://example.com' where option_name = 'siteurl';
update wp_options set option_value = 'http://example.com' where option_name = 'home';

2 - дополнительно указать URL-адрес в файл wp-config.php
define('WP_HOME','http://example.com');
define('WP_SITEURL','http://example.com');

3- Очистить кэш с сервера

4- Очистите кэш вашего браузера и историю (Ура!!! это решило мою проблему без перенаправления)

В Chrome перейдите к chrome://settings/clearBrowserData и очистите кэш изображений и файлов.