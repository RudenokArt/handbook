<?php 
// Номер телефона для регистрации
$arResult['user'] = \Bitrix\Main\UserPhoneAuthTable::getList([
  'filter' => [
    'USER_ID' => $USER->GetID(),
  ],
  'select' => [
    'USER_ID', 'PHONE_NUMBER',
  ],
])->fetch(); 

// ========== USER ==========

function getUserList () {
  $page = 1;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  $filter = ['ACTIVE' => 'Y'];
  $select = [
    'NAV_PARAMS' => ['nPageSize'=>10, 'iNumPage'=>$page],
    'FIELDS' => ['ID', 'NAME', 'LAST_NAME',],
    'SELECT' => [],
  ];
  $src = CUser::GetList('ID','asc', $filter, $select);
  $arr = make_list($src);
  return [
    'page_count' => $src->NavPageCount, 
    'page_number' => $src->NavPageNomer, 
    'list' => $arr,
  ];
}

// id текущего пользователя
global $USER;
return $USER->GetID();


// проверка на принадлежность пользователя к группе exchange_rates:
in_array(CGroup::GetList(($by="id"), ($order="asc"),['STRING_ID'=>'exchange_rates'])->Fetch()['ID'], $USER->GetUserGroupArray());

// добавить пользователя в группу
$arGroups = CUser::GetUserGroup($user_id);
$arGroups[] = $group_id;
CUser::SetUserGroup($user_id, $arGroups);


?>