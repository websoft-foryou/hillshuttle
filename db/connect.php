<?PHP //ACORR Connect to database
$link = mysql_connect('localhost', 'hillshut_airport', 'hillairport!@#');
mysql_select_db('hillshut_live');

if (!$link) {
    die('Could not connect: ' . mysql_error());
}
?>