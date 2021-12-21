<?php 

/**
 * 
 */
class DateAndTime {

	public static function date_interval () { 
		if (isset($_POST['filter'])) {
			if ($_POST['date_filter']=='month') {
				$interval = [
					strtotime(date('Y-m-01')),
					strtotime(date('Y-m-t')), 
				];
			}
			if ($_POST['date_filter']=='prev_month') {
				$interval = [
					strtotime(date('Y-m-01', strtotime('-1 month'))),
					strtotime(date('Y-m-t', strtotime('-1 month'))),
				];
			}
			if ($_POST['date_filter']=='week') {
				$interval = [strtotime('last monday'), strtotime('next monday')];
			}
			if ($_POST['date_filter']=='prev_week') {
				$interval = [strtotime('last monday -1 week'), strtotime('next monday -1 week')];
			}
			if ($_POST['date_filter']=='interval') {
				$interval = [strtotime($_POST['date_for']), strtotime($_POST['date_to'])];
			}
		}
		return $interval;
	}
}

?>