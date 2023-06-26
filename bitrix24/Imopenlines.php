CIMChat::getCrmChatId('DEAL|123')
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

BX.PULL.subscribe({
	moduleId: 'im',
	callback: function (data) {
		console.log(data);
	}.bind(this)
});