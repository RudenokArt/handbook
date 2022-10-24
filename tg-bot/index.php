<?php
//=========Показ ошибок
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//=====================
spl_autoload_register(); // Автозагрузка классов
//=====================

file_put_contents('messages.json', file_get_contents('php://input'));

$tg_bot = new Tg_bot(file_get_contents('php://input'));
$tg_bot->sendButtons();
// $tg_bot->sendBootMessage();

?>

Установить WebHook:
https://api.telegram.org/bot5779405986:AAExrHLhMBmA-HLstR1DbUdcQO05TCL65uo/setWebhook?url=https://vetliva.by/tg-bot/