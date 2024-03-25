<?php 
$host='localhost';
$log='root';
$pas='';
$db='pladas';
$link=mysqli_connect($host,$log,$pas,$db);
$src=mysqli_query($link,'SHOW TABLES FROM pladas');
while ($row = mysqli_fetch_assoc($src)) {
        $arr[] = $row;
}

?>

<pre><?php print_r($arr); ?></pre>