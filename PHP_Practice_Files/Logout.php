<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Log out Page</title>
</head>

<body>

	<?php
	
			session_start();
			$_SESSION['uid'] = null;
			echo "<h1>Thank you</h1> <br /><br />";
			session_destroy();
	
	?>
	
	<a href="index.php">Home</a>

</body>
</html>
