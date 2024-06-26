<?php
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
