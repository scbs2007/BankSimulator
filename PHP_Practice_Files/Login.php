<?php

	ob_start();
	
	session_start();

	$s = $_GET['t1'];

	$pas = $_GET['t2']; 

	include("Connection.php");

	$query = "SELECT * FROM `userauthentication` WHERE UserName='$s' and Password='$pas'";

	$resultSet = mysql_query($query);

	$n = mysql_num_rows($resultSet);

	if($n > 0)
	{
		$_SESSION['uid'] = $s;
		header('Location:Welcome.php');
	}

	else
		header('Location:index.php?a=Wrong Username and/or Password');	

?> 