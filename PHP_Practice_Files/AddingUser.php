<?php

	include("sessionHandler.php");
?>

<?php

	ob_start();

	$usrNameVar = $_GET['usrNameField'];

	$pasVar = $_GET['passField']; 

	include("Connection.php");
	
	$query = "INSERT INTO `userauthentication` VALUES(NULL, '$usrNameVar', $pasVar)";
	
	$resultSet = mysql_query($query);
	
	$n = mysql_num_rows($resultSet);

	if($n > 0)
		echo "<br /> Tharo user ban gayo";

	else
		echo "<br /> Could not add data";
	
?>