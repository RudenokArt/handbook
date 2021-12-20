<?php 

class Tester_error {
  
  public static function get_list($order=[], $filter=[], $select=[]) {
    $res = CTasks::GetList($order, $filter, $select);
    $arr = [];
    while ($item = $res->GetNext()) {
      array_push($arr, $item);
    }
    return $arr;
  }

}

?>