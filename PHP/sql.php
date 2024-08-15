<?php
$host ='localhost';
$log ='root';
$pas ='';
$db ='family-camp';
$link = mysqli_connect($host,$log,$pas,$db);
mysqli_query($link, "SET NAMES 'utf8'");
$src = mysqli_query($link,'SELECT * FROM wp_posts');
while ($row = mysqli_fetch_assoc($src)) {
        $arr[] = $row;
}

// Количество записей
$src = mysqli_query($link,'SELECT COUNT(*) FROM wp_posts');
$qty = mysqli_fetch_assoc($src);


// Очистка БД
$host ='localhost';
$log ='rudenok';
$pas ='rudenok123';
$db ='rudenok';
$link = mysqli_connect($host,$log,$pas,$db);
mysqli_query($link, "SET NAMES 'utf8'");
$src = mysqli_query($link,'SHOW TABLES FROM rudenok');
while ($row = mysqli_fetch_assoc($src)) {
        $arr[] = $row;
}
foreach ($arr as $key => $value) {
        mysqli_query($link,'DROP TABLE '.$value['Tables_in_rudenok']);
}