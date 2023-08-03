<?php
mysql_connect('localhost','hillshut_airport','hillairport!@#');
mysql_select_db('hillshut_live');

// define decimal point
define('DECPOINT', '2');
define('PREG', '/[^0-9\.]/');
define('DOLLAR', '$');

?>