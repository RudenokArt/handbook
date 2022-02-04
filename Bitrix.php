<?php 

/**
 * 
 */



class Bitrix {

  public static function agentCreate () { // Создать агента
    CAgent::AddAgent(
    "WorkReport::reportLogging();", // имя функции
    "", // идентификатор модуля
    "N", // агент не критичен к кол-ву запусков
    60, // интервал запуска - 1 сутки
    "03.02.2022 16:30:00", // дата первой проверки на запуск
    "Y", // агент активен
    "03.02.2022 16:30:00", // дата первого запуска
    "");
  }

  public static function js_library () { // js библиотека
    CJSCore::RegisterExt('Panel_visability_js', array(
      'js' => '/local/gadgets/custom/panel_visability/main.js',
    ));
    CUtil::InitJSCore(array('Panel_visability_js'));
  }

  public static function list_maker($src) {
    $arr = [];
    while ($item = $src->Fetch()) {
      array_push($arr, $item);
    }
    return $arr;
  }

  public static function date_filter () {
    $dateFrom = new \Bitrix\Main\Type\DateTime();
    $dateFrom->add('-10 day');
    $dateTo = new \Bitrix\Main\Type\DateTime();
    $filter = [
      ">=CLOSED_DATE" => $dateFrom,
      "<=CLOSED_DATE" => $dateTo,
      'RESPONSIBLE_ID' => $value['ID'],
    ];
    $src = CTasks::GetList([],$filter, []);
  }
  
}

?>