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
  
}

?>