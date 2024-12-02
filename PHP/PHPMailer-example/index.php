<?php 
// composer require phpmailer/phpmailer - установка
include_once 'vendor/autoload.php';
$mail = new PHPMailer\PHPMailer\PHPMailer;
$mail->CharSet = 'utf-8';
$mail->SMTPDebug = 3; //Подключение отладки SMTP.
$mail->isSMTP(); //Задаем для PHPMailer использовать SMTP.
$mail->Host = "smtp.yandex.ru"; //Устанавливаем имя хоста SMTP
$mail->SMTPAuth = true; // если хост SMTP требует аутентификации для отправки почты
$mail->Username = "postimap@yandex.ru"; //Предоставляем имя пользователя и пароль
$mail->Password = "supwclweykplqyeb";
$mail->SMTPSecure = 'ssl'; //Если для SMTP требует шифрование 
$mail->Port = 465;//Устанавливаем порт TCP для подключения

$mail->From = "postimap@yandex.ru"; 
$mail->FromName = "Полное имя"; 
$mail->addAddress("RudenokArt@yandex.ru", "Имя получателя"); //Предоставляем путь и имя файла вложения 
$mail->addAttachment("composer.json"); //Имя файла необязательно 
$mail->isHTML(true); 
$mail->Subject = "Тема письма"; 
$mail->Body = "<i>Тело письма в HTML</i>"; 
$mail->AltBody = " Это текстовая версия письма "; 
if(!$mail->send()) 
{ 
echo "Ошибка: " . $mail->ErrorInfo;
} 
else 
{ 
echo "Сообщение успешно отправлено"; 
}
