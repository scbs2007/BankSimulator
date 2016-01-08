<?php

$host = 'localhost';
$usr = 'root';
$pass = '';
$db = 'phpmyadmin';

$con = mysql_connect($host,$usr,$pass) or die("Connection Failed!");
$db = mysql_select_db($db) or die("Could not select database !");
//echo "MySQL connection established";

?>
</body>
</html>
