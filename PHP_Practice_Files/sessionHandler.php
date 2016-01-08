<?php

	session_start();
	$inactive = 10;
	
	if( isset($_SESSION['timeout']))
	{
		$session_life = time() - $_SESSION['timeout'];
		if( $session_life > $inactive )
		{
			header("Location:logout.php");
		}
	}

	$_SESSION['timeout'] = time();
?>