<?php

require '../db/connect.php';


if (isset($_POST['name']) === true && empty($_POST['name']) === false) {
	
	 
 
	
	
	$query = mysql_query("SELECT comment FROM dailycomments WHERE date = '" . mysql_real_escape_string(trim($_POST['name'])) . "'");
	echo (mysql_num_rows($query) !== 0) ? mysql_result($query, 0, 'comment') : 'No comment for this date';
	
};

?>