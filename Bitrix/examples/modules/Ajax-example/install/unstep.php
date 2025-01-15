<?php
$APPLICATION->SetTitle(GetMessage('MODULE_UNINSTALLING'));
if(!check_bitrix_sessid()) return;
echo CAdminMessage::ShowNote(GetMessage('MODULE_REMOVED'));