<?php 

// Подключить пролог без шапки
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// SQL запрос к БД
$sql=$wpdb->get_results('SELECT `post_content` FROM `wp_posts`');
print_r($sql);

?>