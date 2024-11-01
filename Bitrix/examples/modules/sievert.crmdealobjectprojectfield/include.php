<?php
  use Bitrix\Main\Loader;
  Loader::registerAutoLoadClasses(
    'sievert.crmdealobjectprojectfield', [
      'Bitrix\Sievert\CrmDealObjectProjectField' => 'lib/CrmDealObjectProjectField.php',
    ]
  );