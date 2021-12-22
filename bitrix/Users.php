<?php 

/**
 * 
 */
class Users {
  
  public static function Users_list ($filter=[], $select=[]) {
    $arr = [];
    $rsUsers = CUser::GetList('ID','asc',$filter,$select);
    while ($item = $rsUsers->GetNext()) {
      array_push($arr, $item);
    }
    return $arr;
  }

}


?>