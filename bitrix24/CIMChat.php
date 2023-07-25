<?php 


// Отправить сообщение от пользвателя копльзователю
\CIMMessage::Add(array(  
	'FROM_USER_ID' => 4,  
	'TO_USER_ID' => 1, 
	'MESSAGE' => 'one more message', 
));  



CIMChat::getCrmChatId('DEAL|123');
$params = [
'filter' => ['=CHAT_ID' => $chatId, '>AUTHOR_ID' => 0],
'order' => ['ID' => 'DESC']
];

$rsMessages = Bitrix\Im\Model\MessageTable::getList($params);
$messages = $rsMessages->fetchAll();
$userId = Bitrix\Imopenlines\Widget\User::register([
'NAME' => $contact['NAME'],
'LAST_NAME' => $contact['LAST_NAME'],
'AVATAR' => CFile::getPath($contact['PHOTO'])
])['ID'];

(new CIMChat)->addUser($chatId, $userId);
CIMChat::getChatData(['ID' => $chatId])['userInChat'][$chatId];
CIMChat::addMessage([
'TO_CHAT_ID' => $chatId,
'FROM_USER_ID' => $userId,
'MESSAGE' => 'mess'
]);

(new Bitrix\Im\User($userId))->isExists()

?>
<script>
	
BX.PULL.subscribe({
	moduleId: 'im',
	callback: function (data) {
		console.log(data);
	}.bind(this)
});

</script>


<?php

Bitrix\Main\Loader::includeModule('im');
Bitrix\Main\Loader::includeModule('crm');

class Mess {

	public const FIELD = 'ORIGIN_ID'; // Поле в карточке контакта, которое хранит ID пользователя Открытых Линий (ОЛ). Вместо ORIGIN_ID используй что-то типа UF_CRM_CONTACT_USER_ID

	public static function load($contactId, $dealId = false) { // Метод возвращает все сообщения чата

		$chatId = self::getChatId($contactId, $dealId); // Получаем ID чата

		$messages = Bitrix\Im\Model\MessageTable::getList([ // Достаем все сообщения чата, кроме системных
			'filter' => ['=CHAT_ID' => $chatId, '>AUTHOR_ID' => 0],
			'order' => ['ID' => 'DESC']
		])->fetchAll();

		$contactUserId = CCrmContact::getById($contactId)[self::FIELD]; // Получаем ID пользователя ОЛ

		foreach($messages as $key => $mess) { // Формируем удобный массив

			$messages[$key] = [
				'MESSAGE' => $mess['MESSAGE'], // Текст сообщения
				'DATE' => $mess['DATE_CREATE']->__toString(), // Дата отправки
				'AUTHOR' => CUser::formatName(CSite::getNameFormat(), CUser::getById($contactUserId)->fetch(), true, false), // Имя отправителя
				'ME' => $mess['AUTHOR_ID'] == $contactUserId ? 'Y': 'N' // Сообщение принадлежит контакту CRM (Y/N)
			];

		}

		return $messages; // Возвращаем сообщения

	}

	public static function send($message, $contactId, $dealId = false) { // Отправляем сообщение в чат

		$contact = CCrmContact::getById($contactId); // Загружаем контакта

		if($contact[self::FIELD] > 0 && (new Bitrix\Im\User($contact[self::FIELD]))->isExists()) { // Если пользователь ОЛ существует - используем его, иначе регистрируем нового

			$userId = $contact[self::FIELD];

		} else {

			$userId = Bitrix\Imopenlines\Widget\User::register([ // Собственно, регистрация пользователя ОЛ
				'NAME' => $contact['NAME'],
				'LAST_NAME' => $contact['LAST_NAME'],
				'AVATAR' => CFile::getPath($contact['PHOTO'])
			])['ID'];

			$crmFields = [self::FIELD => $userId];
			(new CCrmContact(false))->update($contactId, $crmFields); // Сохраняем ID пользователя ОЛ в карточку контакта

		}

		$chatId = self::getChatId($contactId, $dealId); // Получаем ID чата
		$userInChat = CIMChat::getChatData(['ID' => $chatId])['userInChat'][$chatId]; // Получаем список участников чата

		if (!in_array($userId, $userInChat)) (new CIMChat)->addUser($chatId, $userId); // Если пользователя нет в чате - добавляем

		return CIMChat::addMessage([ // Отправляем сообщение в чат
			'TO_CHAT_ID' => $chatId,
			'FROM_USER_ID' => $userId,
			'MESSAGE' => $message
		]);

	}

	//////////// Вспомогательные методы

	private static function getChatId($contactId, $dealId) {

		$crmChat = $dealId ? CCrmOwnerType::DealName . '|' . $dealId : CCrmOwnerType::ContactName . '|' . $contactId; // Формируем строку вида DEAL|123 или CONTACT|456
		return CIMChat::getCrmChatId($crmChat); // Возвращаем ID чата

	}


}
?>