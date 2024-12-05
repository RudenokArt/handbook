<?php

// DB connect
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$host = 'localhost';
$db = 'fortest';
$user = 'root'; // имя для входа в БД
$pass = ''; // пароль для входа в БД
$charset = 'utf8';
$dsn = "mysql:host=$host; dbname=$db; charset=$charset";

$opt = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

// DB connect checking
try {
	$pdo = new PDO($dsn, $user, $pass, $opt);
	echo 'DB is connected';
} catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

// Запрос в PDO
$res = $pdo->query('SELECT * FROM users');
while ($row = $res->fetch()) {
	$arr[] = $row;
}

// ===== ПЛЕЙСХОЛДЕРЫ =====
// Позволяют вставлять переменные в текст запроса.

// Позиционный плейсхолдер. 
// (параметры в массиве должны следовать в указанном порядке)
$res = $pdo->prepare('SELECT * FROM users WHERE id=? AND role=?');
$res->execute([1,1]);
while ($row = $res->fetch()) {
	$arr[] = $row;
}

// Позиционная привязка переменных с указанием типа
$res = $pdo->prepare('SELECT * FROM users WHERE id=:id AND login=:login');
$id = 1;
$login = 'user1';
$res->bindValue(1, $id, PDO::PARAM_INT);
$res->bindValue(2, $login, PDO::PARAM_STR);
$res->execute();
while ($row = $res->fetch()) {
	$arr[] = $row;
}

// Именнованый плейсхолдер
// (параметры должны определяются ключами ассоциативного массива)
$res = $pdo->prepare('SELECT * FROM users WHERE id=? AND login=?');
$id = 1;
$login = 'user1';
$res->bindValue(1, $id, PDO::PARAM_INT);
$res->bindValue(2, $login, PDO::PARAM_STR);
$res->execute();
while ($row = $res->fetch()) {
	$arr[] = $row;
}

// Именованная привязка переменных с указанием типа
$res = $pdo->prepare('SELECT * FROM users WHERE id=:id AND login=:login');
$id = 1;
$login = 'user1';
$res->bindValue('id', $id, PDO::PARAM_INT);
$res->bindValue('login', $login, PDO::PARAM_STR);
$res->execute();
while ($row = $res->fetch()) {
	$arr[] = $row;
}