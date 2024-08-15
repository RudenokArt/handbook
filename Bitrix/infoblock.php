<?php 

// ===== СВОИЙСТВА ИНФОБЛОКОВ =====

// создать свойство "Привязка к сотруднику" с проверкой на существование
$iblockId = CIBlock::GetList([], [
  'CODE' => 'absence',
])->Fetch()['ID'];
$prop = CIBlockProperty::GetList([], [
  "CODE" => "SIEVERT_ABSENT_REPLACEMENT",
  'IBLOCK_ID' => $iblockId,
])->Fetch();
if (!$prop) {
  $arFields = Array(
    "NAME" => "Replacement for absent employee",
    "ACTIVE" => "Y",
    "SORT" => "100",
    "CODE" => "SIEVERT_ABSENT_REPLACEMENT",
    "PROPERTY_TYPE" => "S",
    "USER_TYPE" => "employee",
    "IBLOCK_ID" => $iblockId,
  );
  $ibp = new CIBlockProperty;
  $PropID = $ibp->Add($arFields);
}

// класс свойства "деньги"
// /bitrix/modules/currency/lib/integration/iblockmoneyproperty.php
// Баг: // 'CheckFields' => [$className, 'checkFields'],

// Создать свойство типа "Money"
$arFields = Array(
  "NAME" => "Leasingrate",
  "ACTIVE" => "Y",
  "SORT" => "100",
  "CODE" => "LEASING_RATE",
  "PROPERTY_TYPE" => "S",
  "USER_TYPE" => "Money",
  "IBLOCK_ID" => 15
);
$ibp = new CIBlockProperty;
$PropID = $ibp->Add($arFields);

// Создать свойство типа список
$arFields = Array(
  "NAME" => "moose",
  "ACTIVE" => "Y",
  "SORT" => "100",
  "CODE" => "MOOSE",
  "PROPERTY_TYPE" => "L",
  "IBLOCK_ID" => 14
);
$arFields["VALUES"][0] = Array(
  "VALUE" => "moose",
  "DEF" => "N",
  "SORT" => "100"
);
$arFields["VALUES"][1] = Array(
  "VALUE" => "frame",
  "DEF" => "N",
  "SORT" => "200"
);
$arFields["VALUES"][2] = Array(
  "VALUE" => "install",
  "DEF" => "N",
  "SORT" => "300"
);
$ibp = new CIBlockProperty;
$PropID = $ibp->Add($arFields);

// Сложный фильтр 

function getSerarchFilter () {
  if (isset($_GET['search']) and !empty($_GET['search'])) {
    $filter = [
      'IBLOCK_CODE' => 'tours',
      'SECTION_CODE' => $this->section_code,
      [
        "LOGIC" => "OR",
        ["NAME" => '%'.$_GET['search'].'%'],
        ["DETAIL_TEXT" => '%'.$_GET['search'].'%'],
        ["PREVIEW_TEXT" => '%'.$_GET['search'].'%'],
      ]
    ];
  } else {
    $filter = [
      'IBLOCK_CODE' => 'tours',
      'SECTION_CODE' => $this->section_code,
    ];
  }
  return $filter;
}

// сортировка по двум признакам
Array(
 "LOGIC" => "AND",
 array("ID" => "DESC"),
 array("DATE_ACTIVE_FROM" => "ASC"));

function getIBlockUFProperties () { // получить пользовательские поля инфоблока
  $src = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID'=>20]);
  return list_maker($src);
};

// Простая пагинация для инфоблока
$pagination = [
  'page_count' => $src->NavPageCount, 
  'page_number' => $src->NavPageNomer,
]; 
if ($arResult['pagination']['page_number']>1): ?>
  <a href="?page_number=1">1</a>...
<?php endif ?>
<?php if ($arResult['pagination']['page_number']>2): ?>
  <a href="?page_number=<?php echo $arResult['pagination']['page_number']-1;?>">
    <?php echo$arResult['pagination']['page_number']-1;?>
  </a>
<?php endif ?>
<?php echo $arResult['pagination']['page_number'];?>
<?php if ($arResult['pagination']['page_number']<$arResult['pagination']['page_count']): ?>
 <a href="?page_number=<?php echo $arResult['pagination']['page_number']+1;?>">
  <?php echo $arResult['pagination']['page_number']+1;?>
</a> 
<?php endif ?>
...
<a href="?page_number=<?php echo $arResult['pagination']['page_count'];?>">
  <?php echo $arResult['pagination']['page_count'];?>
</a>
<?php

$GLOBALS['bottom_menu_filter'] = [// фильтр для компонента (news.list)
'SECTION_CODE' => 'bottom_menu',
]; 
$GLOBALS['main_event_filter'] = [ // Фильтр по свойству
'ACTIVE'=>'Y', 
'PROPERTY_main_event_VALUE'=>'Y'
];


?>