<?php CModule::IncludeModule("iblock");
/**
 * 
 */
class InfoBlock {
	
	public static function get_list($order=[], $filter=[], $group=false, $nav=false, $fields=[]) {
		$arr = [];
		$raw = CIBlockElement::GetList($order, $filter, $gorup, $nav, $fields);
		while ($item = $raw->GetNext()) {
			array_push($arr, $item);
		}
		return $arr;
	}

}

?>