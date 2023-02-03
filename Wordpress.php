<?php 

// Подключить пролог без шапки
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
// Путь до темы (php path);
get_template_directory();
// url темы
get_stylesheet_directory_uri();


// SQL запрос к БД
$sql=$wpdb->get_results('SELECT `post_content` FROM `wp_posts`');
print_r($sql);

// Добавить страницу к админке WP
add_action( 'admin_menu', 'true_top_menu_page', 25 );
function true_top_menu_page(){
 
	add_menu_page(
		'Настройки конструктора', // тайтл страницы
		'Настройки конструктора', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'constructor_options', // ярлык страницы
		'constructor_options_manager', // функция, которая выводит содержимое страницы
		'dashicons-admin-generic', // иконка, в данном случае из Dashicons
		7 // позиция в меню
	);
} 
function constructor_options_manager () {
	echo 'привет';
}

?>


