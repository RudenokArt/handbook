<?php 
$APPLICATION->SetTitle(GetMessage('MODULE_INSTALLING'));
if(!check_bitrix_sessid()) return;
echo CAdminMessage::ShowNote(GetMessage('MODULE_INSTALLED'));


