<?php 

/**
 * 
 */
class Bitrix {

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