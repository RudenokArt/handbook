<?php 

// ========== INFOBLOCKS ==========

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