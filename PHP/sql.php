<?php
$host ='localhost';
$log ='root';
$pas ='';
$db ='family-camp';
$link = mysqli_connect($host,$log,$pas,$db);
$src = mysqli_query($link,'SELECT * FROM wp_posts');
while ($row = mysqli_fetch_assoc($src)) {
        $arr[] = $row;
}

?>
<pre><?php print_r($src); ?></pre>
<pre><?php print_r($arr); ?></pre>